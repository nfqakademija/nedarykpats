<?php
namespace App\Handler;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserCreationHandler
 * @package App\Handler
 */
class UserUpdateHandler
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
     * @param User $user
     * @param string $firstName
     * @param string $lastName
     * @return User
     */
    public function handle(User $user, ?string $firstName, ?string $lastName)
    {
        if ($user->getName() === null) {
            $user->setName($firstName);
        }
        if ($user->getLastName() === null) {
            $user->setLastName($lastName);
        }
        return $user;
    }
}
