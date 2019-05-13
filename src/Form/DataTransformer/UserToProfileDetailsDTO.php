<?php


namespace App\Form\DataTransformer;

use App\DTO\ProfileDetailsDTO;
use App\Entity\User;
use Symfony\Component\Form\DataTransformerInterface;

class UserToProfileDetailsDTO implements DataTransformerInterface
{

    /**
     * @param User $user
     * @return ProfileDetailsDTO
     */
    public function transform($user)
    {
        $profileDetailsDTO = new ProfileDetailsDTO();
        $profileDetailsDTO
            ->setName($user->getName())
            ->setLastName($user->getLastName())
            ->setDescription($user->getDescription())
            ->setCity($user->getCity());

        return $profileDetailsDTO;
    }

    /**
     * @param ProfileDetailsDTO $profileDTO
     * @return ProfileDetailsDTO void
     * @throws \Exception
     */
    public function reverseTransform($profileDTO)
    {
        return $profileDTO;
    }
}
