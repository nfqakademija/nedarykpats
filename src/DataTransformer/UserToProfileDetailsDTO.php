<?php


namespace App\DataTransformer;

use App\DTO\ProfileDetailsDTO;
use App\Entity\User;

class UserToProfileDetailsDTO
{
    /**
     * @param User $user
     * @return ProfileDetailsDTO
     */
    public function transform(User $user)
    {
        $profileDetailsDTO = new ProfileDetailsDTO();
        $profileDetailsDTO
            ->setName($user->getName())
            ->setLastName($user->getLastName())
            ->setDescription($user->getDescription())
            ->setCity($user->getCity());

        return $profileDetailsDTO;
    }
}
