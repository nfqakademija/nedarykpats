<?php

namespace App\Handler;

use App\DTO\RegistrationFormDTO;
use App\Entity\User;
use App\Service\TokenGeneratorService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * RegistrationHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenGeneratorService $tokenGeneratorService
     * @param EmailHandler $emailHandler
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenGeneratorService $tokenGeneratorService,
        EmailHandler $emailHandler,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->tokenGeneratorService = $tokenGeneratorService;
        $this->emailHandler = $emailHandler;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param RegistrationFormDTO $registrationFormDTO
     * @return User
     * @throws Exception
     */
    public function handle(RegistrationFormDTO $registrationFormDTO) : User
    {
        $user = new User();

        $user->setEmail($registrationFormDTO->getEmail())
            ->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $registrationFormDTO->getPlainPassword()
                )
            )
            ->setRoles(['ROLE_USER'])
            ->setIsConfirmed(false)
            ->setCreatedAt(new DateTime('now'))
            ->setIdentification(substr(md5(microtime()), 0, 7));


        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $hash = $this->tokenGeneratorService->generate($user, null, null);
        $this->emailHandler->sendRegistrationConfirmation($user->getEmail(), $hash->getHash());

        return $user;
    }
}
