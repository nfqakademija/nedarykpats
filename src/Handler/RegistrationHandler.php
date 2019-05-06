<?php


namespace App\Handler;

use App\Entity\User;
use App\Service\EmailHandler;
use App\Service\TokenGeneratorService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class RegistrationHandler
 * @package App\Service
 */
class RegistrationHandler
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TokenGeneratorService
     */
    private $tokenGeneratorService;

    /**
     * @var EmailHandler
     */
    private $emailHandler;

    /**
     * RegistrationHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenGeneratorService $tokenGeneratorService
     * @param EmailHandler $emailHandler
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenGeneratorService $tokenGeneratorService,
        EmailHandler $emailHandler)
    {
        $this->entityManager = $entityManager;
        $this->tokenGeneratorService = $tokenGeneratorService;
        $this->emailHandler = $emailHandler;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function handle(User $user) {
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $hash = $this->tokenGeneratorService->generate($user->getEmail(), new \DateTime('now'), $user, null, null);
        $this->emailHandler->sendRegistrationConfirmation($user->getEmail(), $hash->getHash());
    }
}
