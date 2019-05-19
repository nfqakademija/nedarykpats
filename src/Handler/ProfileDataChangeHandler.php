<?php

namespace App\Handler;

use App\DTO\ProfileDetailsDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProfileDataChangeHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * TokenConsumerService constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }


    /**
     * @param ProfileDetailsDTO $profileDetailsDTO
     */
    public function handle(ProfileDetailsDTO $profileDetailsDTO)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        if ($profileDetailsDTO->getName()) {
            $user->setName($profileDetailsDTO->getName());
        }

        if ($profileDetailsDTO->getDescription()) {
            $user->setDescription($profileDetailsDTO->getDescription());
        }
        if ($profileDetailsDTO->getCity()) {
            $user->setCity($profileDetailsDTO->getCity());
        }

        $this->entityManager->flush();
    }
}
