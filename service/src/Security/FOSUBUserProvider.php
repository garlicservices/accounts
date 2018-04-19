<?php

namespace App\Security;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseProvider;
use Garlic\User\Exception\AccountNotLinkedException;
use App\Entity\User;

/**
 * Class FOSUBUserProvider
 */
class FOSUBUserProvider extends BaseProvider
{
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        if (null === $user = $this->userManager
                ->findUserByEmail($response->getEmail())) {
            throw new AccountNotLinkedException(sprintf("User '%s' not found.", $response->getEmail()));
        }

        $this->setUserData($response, $user);

        $setterPropertyName = 'set'.ucfirst($this->getProperty($response));
        $setterTokenName = 'set'.ucfirst($response->getResourceOwner()->getName()).'AccessToken';
        $user->$setterPropertyName($response->getUsername());
        $user->$setterTokenName($response->getAccessToken());
        $this->userManager->updateUser($user);

        return $user;
    }

    /**
     * Set user data
     *
     * @param UserResponseInterface $response
     * @param User                  $user
     */
    private function setUserData(UserResponseInterface $response, User $user)
    {
        if (!empty($profilePicture = $response->getProfilePicture())) {
            $user->setProfilePicture($profilePicture, false);
        }

        if (!empty($firstName = $response->getFirstName())) {
            $user->setFirstName($firstName, false);
        }

        if (!empty($lastName = $response->getLastName())) {
            $user->setLastName($lastName, false);
        }

        if (!empty($website = $response->getWebsite())) {
            $user->setWebsite($website, false);
        }

        if (!empty($gender = $response->getGender())) {
            $user->setGender($gender, false);
        }


        $user->setEnabled(true);
    }
}
