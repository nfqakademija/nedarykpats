<?php


namespace App\Handler;

use App\DTO\ProfilePasswordDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilePasswordChangeHandler
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
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface $tokenStorage
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ProfilePasswordDTO $profilePasswordDTO
     * @return bool
     */
    public function handle(ProfilePasswordDTO $profilePasswordDTO): bool
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $success = false;

        if ($profilePasswordDTO->getNewPassword() === $profilePasswordDTO->getNewPasswordConfirmation()) {
            $newPassword = $this->passwordEncoder->encodePassword($user, $profilePasswordDTO->getNewPassword());
            $user->setPassword($newPassword);
            $this->entityManager->flush();
            $success = true;
        }

        return $success;
    }
}
