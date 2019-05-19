<?php


namespace App\Handler;

use App\DTO\ProfilePasswordDTO;
use App\Entity\User;
use App\Service\TokenGeneratorService;
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
     * @var TokenGeneratorService
     */
    private $tokenGeneratorService;

    /**
     * @var EmailHandler
     */
    private $emailHandler;

    /**
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface $tokenStorage
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TokenGeneratorService $tokenGeneratorService
     * @param EmailHandler $emailHandler
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        UserPasswordEncoderInterface $passwordEncoder,
        TokenGeneratorService $tokenGeneratorService,
        EmailHandler $emailHandler
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenGeneratorService = $tokenGeneratorService;
        $this->emailHandler = $emailHandler;
    }

    /**
     * @param ProfilePasswordDTO $profilePasswordDTO
     * @return void
     * @throws \Exception
     */
    public function handle(ProfilePasswordDTO $profilePasswordDTO): void
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $newPassword = $this->passwordEncoder->encodePassword($user, $profilePasswordDTO->getNewPassword());
        $user->setPassword($newPassword);

        $this->emailHandler->sendEmailPasswordWasChanged(
            $user->getEmail(),
            $this->tokenGeneratorService->generate($user, null, null)->getHash()
        );

        $this->entityManager->flush();
    }
}
