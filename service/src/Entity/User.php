<?php

namespace App\Entity;

use Garlic\User\Entity\AvatarTrait;
use Garlic\User\Entity\User as BaseUser;
use Garlic\User\Entity\TwoFactorTrait;
use Garlic\User\Entity\TrustedComputerTrait;
use Doctrine\ORM\Mapping as ORM;
use Scheb\TwoFactorBundle\Model\TrustedComputerInterface;
use Swagger\Annotations as SWG;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface;

/**
 * Class User
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 *
 * @UniqueEntity(
 *     fields={"email"},
 *     errorPath="email",
 *     message="fos_user.email.already_used",
 *     groups={"ServiceRegistration"}
 * )
 *
 * @SWG\Definition()
 */
class User extends BaseUser implements TwoFactorInterface, TrustedComputerInterface
{
    const USER_GENDER_MALE = 1;
    const USER_GENDER_FEMALE = 2;

    const USER_GENDERS = [
        self::USER_GENDER_MALE   => 'male',
        self::USER_GENDER_FEMALE => 'female',
    ];

    use DateTrait;
    use UserProfileTrait;
    use SocialNetworkTrait;
    use TwoFactorTrait;
    use TrustedComputerTrait;
    use AvatarTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="fos_user.email.blank", groups={"ServiceRegistration"})
     * @Assert\Email(checkMX=true)
     * @Assert\Length(
     *     min="2",
     *     minMessage="fos_user.email.short",
     *     max="255",
     *     maxMessage="fos_user.email.long",
     *     groups={"ServiceRegistration"}
     * )
     * @Assert\Email(message="fos_user.email.invalid", checkMX=true, groups={"ServiceRegistration"})
     */
    protected $email;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="fos_user.email.blank", groups={"ServiceRegistration"})
     * @Assert\Length(
     *     min="2",
     *     minMessage="fos_user.password.short",
     *     max="4096",
     *     groups={"ServiceRegistration"}
     * )
     */
    protected $plainPassword;

    /**
     * Used for paste confirmation url for confirm email
     *
     * @var string
     */
    private $confirmationUrl;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    protected $confirmEmailResentAt;

    /**
     * Image file
     *
     * @var File
     *
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "The maxmimum allowed file size is 5MB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     */
    protected $file;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->roles = ['ROLE_USER'];
        $this->setIsTwoFactorEnable(false);
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }

    /**
     * Get confirmation url
     *
     * @return string
     */
    public function getConfirmationUrl()
    {
        return $this->confirmationUrl;
    }

    /**
     * Set confirmation url
     *
     * @param string $confirmationUrl
     */
    public function setConfirmationUrl(string $confirmationUrl)
    {
        $this->confirmationUrl = $confirmationUrl;
    }

    /**
     * @return \DateTime
     */
    public function getConfirmEmailResentAt()
    {
        return $this->confirmEmailResentAt;
    }

    /**
     * @param \DateTime $confirmEmailResentAt
     */
    public function setConfirmEmailResentAt(\DateTime $confirmEmailResentAt)
    {
        $this->confirmEmailResentAt = $confirmEmailResentAt;
    }

    /**
     * Get file
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set file
     *
     * @param File $file
     *
     * @return User
     */
    public function setFile(File $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Checks whether the confirmation request not abused and return when cant send email
     *
     * @param int $ttl Requests older than this many seconds will be considered abused
     *
     * @return int
     */
    public function timeToResentEmailConfirmation($ttl)
    {
        if (!$this->getConfirmEmailResentAt() instanceof \DateTime) {
            return false;
        }

        $timeToResent = $this->getConfirmEmailResentAt()->getTimestamp() + $ttl - time();
        if ($timeToResent <= 0) {
            return false;
        }

        return $timeToResent;
    }

    /**
     * Return array with fields for serialization. Note fields from this method is different with User:serialize()
     *
     * @return array
     */
    public function getSerializeFields()
    {
        return [
            'id'             => $this->getId(),
            'email'          => $this->getEmail(),
            'website'        => $this->getWebsite(),
            'firstName'      => $this->getFirstName(),
            'lastName'       => $this->getLastName(),
            'phone'          => $this->getPhone(),
            'country'        => $this->getCountry(),
            'profilePicture' => $this->getProfilePicture(),
        ];
    }
}
