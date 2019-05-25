<?php
namespace App\Handler;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserCreationHandler
 * @package App\Handler
 */
class UserCreationHandler
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * UserCreationHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $email
     * @param string|null $name
     * @return User
     * @throws \Exception
     */
    public function createUser(string $email, ?string $name = null)
    {
        $user = new User();
        $user->setEmail($email)
            ->setName($name)
            ->setRoles(['ROLE_USER'])
            ->setIsConfirmed(false)
            ->setCreatedAt(new \DateTime('now'))
            ->setIdentification(substr(md5(microtime()), 0, 7));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
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
