<?php


namespace App\Service;

use App\Entity\Token;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationHandler
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * RegistrationHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $token
     * @return bool
     */
    public function validateToken($token)
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['token' => $token]);

        if (!$user) {
            $user->setIsConfirmed(true);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return true;
        }
        return false;
    }


    /**
     * @param string $email
     * @throws \Exception
     * @return string
     */
    public function createLoginHash(string $email): string
    {

        $random_prefix = rand();
        $random_suffix = rand();
        $hash = md5($random_prefix.$email.$random_suffix);
        $createDate = new \DateTime('now');

        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            $user = new User();
            $user->setEmail($email)
                ->setRoles(['ROLE_USER'])
                ->setIsConfirmed(false)
                ->setCreatedAt($createDate);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        $token = new Token();
        $token
            ->setHash($hash)
            ->setCreatedAt(new \DateTime('now'))
            ->setExpiresAt($createDate->modify('+ 2 hours'))
            ->setExpired(false)
            ->setUser($user);

        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return $hash;
    }
}
