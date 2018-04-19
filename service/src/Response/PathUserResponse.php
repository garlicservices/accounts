<?php

namespace App\Response;

use HWI\Bundle\OAuthBundle\OAuth\Response\PathUserResponse as BasePathUserResponse;
use App\Entity\User;

/**
 * Class PathUserResponse
 */
class PathUserResponse extends BasePathUserResponse
{
    const GENDER_NAMES = [
        User::USER_GENDER_MALE   => [
            'male',
        ],
        User::USER_GENDER_FEMALE => [
            'female',
        ],
    ];

    /**
     * @var array
     */
    public $paths = [
        'identifier'     => null,
        'nickname'       => null,
        'firstname'      => null,
        'lastname'       => null,
        'realname'       => null,
        'email'          => null,
        'profilepicture' => null,
        'website'        => null,
        'gender'         => null,
    ];

    /**
     * Get website
     *
     * @return null|string
     */
    public function getWebsite()
    {
        return $this->getValueForPath('website');
    }

    /**
     * Get gender
     *
     * @return null|string
     */
    public function getGender()
    {
        $gender = $this->getValueForPath('gender');

        return self::getGenderId($gender);
    }

    /**
     * Get gender id
     *
     * @param string $genderName
     *
     * @return int|null
     */
    public static function getGenderId($genderName)
    {
        foreach (self::GENDER_NAMES as $genderId => $genderNames) {
            if (in_array($genderName, $genderNames)) {
                return $genderId;
            }
        }

        return null;
    }
}
