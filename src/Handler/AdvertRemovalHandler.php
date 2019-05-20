<?php

namespace App\Handler;

use App\Entity\Advert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AdvertRemovalHandler
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * AdvertCreationHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Advert $advert
     * @return void
     */
    public function handle(Advert $advert)
    {
        $advert->setIsConfirmed(false);
        $this->entityManager->flush();
    }
}
