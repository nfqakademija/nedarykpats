<?php
namespace App\Handler;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Client\Provider\GoogleUser;

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
     * @param int|null $googleUserID
     * @param bool|null $isConfirmed
     * @return User
     * @throws \Exception
     */
    public function createUser(
        string $email,
        ?string $name = null,
        ?int $googleUserID = null,
        ?bool $isConfirmed = false
    ) {
        $user = new User();
        $user->setEmail($email)
            ->setName($name)
            ->setRoles(['ROLE_USER'])
            ->setIsConfirmed($isConfirmed)
            ->setCreatedAt(new \DateTime('now'))
            ->setIdentification(substr(md5(microtime()), 0, 7))
            ->setGoogleID($googleUserID);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
