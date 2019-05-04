<?php


namespace App\Service;

use App\Entity\Token;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\TokenGeneratorService;

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
     * RegistrationHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenGeneratorService $tokenGeneratorService
     */
    public function __construct(EntityManagerInterface $entityManager, TokenGeneratorService $tokenGeneratorService)
    {
        $this->entityManager = $entityManager;
        $this->tokenGeneratorService = $tokenGeneratorService;
    }



    /**
     * @param string $email
     * @return string
     * @throws \Exception
     */
    public function createLoginHash(string $email): string
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);

        $createDate =  new \DateTime('now');

        if (!$user) {
            $user = $this->createUser($createDate, $email);
        }

        $token =  $this->tokenGeneratorService->generate($email, $createDate, $user, null, null);

        return $token->getHash();
    }


    /**
     * @param \DateTime $createDate
     * @param string $email
     * @return User
     */
    private function createUser(\DateTime $createDate, string $email)
    {
        $user = new User();
        $user->setEmail($email)
            ->setRoles(['ROLE_USER'])
            ->setIsConfirmed(false)
            ->setCreatedAt($createDate);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
