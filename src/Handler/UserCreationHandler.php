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
     * @param string|null $firstName
     * @param string|null $lastName
     * @return User
     * @throws \Exception
     */
    public function createUser(string $email, ?string $firstName = null, ?string $lastName = null)
    {
        $user = new User();
        $user->setEmail($email)
            ->setName($firstName)
            ->setLastName($lastName)
            ->setRoles(['ROLE_USER'])
            ->setIsConfirmed(false)
            ->setCreatedAt(new \DateTime('now'));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param string $email
     * @return User
     */
    public function getUser(string $email) : ?User
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);
        return $user;
    }
}
