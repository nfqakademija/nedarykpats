<?php

namespace App\Handler;

use App\Entity\ImageGallery;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ImageRemovalHandler
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ImageGallery $imageGallery
     * @param User $user
     */
    public function handle(ImageGallery $imageGallery, User $user)
    {
        if ($imageGallery->getUser() === $user) {
            $this->entityManager->remove($imageGallery);
            $this->entityManager->flush();
        }
    }
}
