<?php
namespace App\Handler;

use App\Entity\User;
use App\Service\TokenGeneratorService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SingleUseLoginHandler
 * @package App\Handler
 */
class SingleUseLoginHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserCreationHandler
     */
    private $userCreationHandler;

    /**
     * @var TokenGeneratorService
     */
    private $tokenGeneratorService;

    /**
     * @var EmailHandler
     */
    private $emailHandler;

    /**
     * SingleUseLoginHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserCreationHandler $userCreationHandler
     * @param TokenGeneratorService $tokenGeneratorService
     * @param EmailHandler $emailHandler
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UserCreationHandler $userCreationHandler,
        TokenGeneratorService $tokenGeneratorService,
        EmailHandler $emailHandler
    ) {
        $this->entityManager = $entityManager;
        $this->userCreationHandler = $userCreationHandler;
        $this->tokenGeneratorService = $tokenGeneratorService;
        $this->emailHandler = $emailHandler;
    }

    /**
     * @param string $email
     * @throws \Exception
     */
    public function handle(string $email)
    {
        $user = $this->userCreationHandler->getUser($email);
        if (!$user) {
            $user = $this->userCreationHandler->createUser($email);
        }
        $hash = $this->tokenGeneratorService->generate( $user, null, null);
        $this->emailHandler->sendSingleLoginEmail($email, $hash->getHash());
    }
}
