<?php

namespace App\Entity;

/**
 * Trait UserProfileTrait
 *
 * @SWG\Definition()
 */
trait UserProfileTrait
{
    /**
     * First Name
     *
     * @var string
     *
     * @ORM\Column(type="string", name="first_name", nullable=true, length=64)
     *
     * @SWG\Property()
     */
    private $firstName;

    /**
     * Last Name
     *
     * @var string
     *
     * @ORM\Column(type="string", name="last_name", nullable=true, length=64)
     *
     * @SWG\Property()
     */
    private $lastName;

    /**
     * Phone
     *
     * @var string
     *
     * @ORM\Column(type="string", name="phone", nullable=true, length=16)
     *
     * @SWG\Property()
     */
    private $phone;

    /**
     * Website
     *
     * @var string
     *
     * @ORM\Column(type="string", name="website", nullable=true, length=64)
     *
     * @SWG\Property()
     */
    private $website;

    /**
     * Avatar
     *
     * @var string
     *
     * @ORM\Column(type="string", name="profile_picture", nullable=true, length=256)
     *
     * @SWG\Property()
     */
    private $profilePicture;

    /**
     * Country
     *
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=8, nullable=true)
     */
    private $country;

    /**
     * Gender
     *
     * @var int
     *
     * @ORM\Column(type="smallint", name="gender", length=2, nullable=true)
     *
     * @SWG\Property()
     */
    private $gender;

    /**
     * Get first name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set first name
     *
     * @param string $firstName
     * @param bool   $replace
     *
     * @return $this
     */
    public function setFirstName($firstName, $replace = true)
    {
        if (!$replace && !empty($this->firstName)) {
            return $this;
        }

        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set last name
     *
     * @param string $lastName
     * @param bool   $replace
     *
     * @return $this
     */
    public function setLastName($lastName, $replace = true)
    {
        if (!$replace && !empty($this->lastName)) {
            return $this;
        }

        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get Phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set Phone
     *
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get Website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set Website
     *
     * @param string $website
     * @param bool   $replace
     *
     * @return $this
     */
    public function setWebsite($website, $replace = true)
    {
        if (!$replace && !empty($this->website)) {
            return $this;
        }

        $this->website = $website;

        return $this;
    }

    /**
     * Get  profile picture
     *
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * Set profile picture
     *
     * @param string $profilePicture
     * @param bool   $replace
     *
     * @return $this
     */
    public function setProfilePicture($profilePicture, $replace = true)
    {
        if (!$replace && !empty($this->profilePicture)) {
            return $this;
        }

        $this->profilePicture = $profilePicture;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get gender
     *
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set gender
     *
     * @param int  $gender
     * @param bool $replace
     *
     * @return $this
     */
    public function setGender($gender, $replace = true)
    {
        if (!$replace && !empty($this->gender)) {
            return $this;
        }

        $this->gender = $gender;

        return $this;
    }
}
