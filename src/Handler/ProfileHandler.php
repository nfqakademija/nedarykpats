<?php


namespace App\Handler;


use App\DTO\ProfileDetailsDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ProfileHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * TokenConsumerService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }


    /**
     * @param User $user
     * @param ProfileDetailsDTO $profileDetailsDTO
     */
    public function handle(User $user, ProfileDetailsDTO $profileDetailsDTO)
    {

        if ($profileDetailsDTO->getName()){
            $user->setName($profileDetailsDTO->getName());
        }
        if ($profileDetailsDTO->getLastName()){
            $user->setLastName($profileDetailsDTO->getLastName());
        }

        if ($profileDetailsDTO->getDescription());{
            $user->setDescription($profileDetailsDTO->getDescription());
        }

        $this->entityManager->flush();
    }


}