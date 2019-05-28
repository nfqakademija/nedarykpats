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
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function handle(string $email): bool
    {
        $user = $this->userCreationHandler->getUser($email);
        if ($user instanceof User) {
            $hash = $this->tokenGeneratorService->generate($user, null, null);
            $this->emailHandler->sendSingleLoginEmail($email, $hash->getHash());

            return true;
        }
        return false;
    }
}
