<?php

namespace App\Handler;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserRetrieveHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * UserRetrieveHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $email
     * @return User
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUser(string $email) : ?User
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findUserByEmail($email);
        return $user;
    }
}
