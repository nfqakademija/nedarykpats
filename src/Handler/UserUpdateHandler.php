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
     * @param string $name
     * @return User
     */
    public function handle(User $user, ?string $name)
    {
        if ($user->getName() === null) {
            $user->setName($name);
        }
        return $user;
    }
}
