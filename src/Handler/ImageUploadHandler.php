<?php

namespace App\Handler;

use App\DTO\ImageGalleryFormDTO;
use App\Entity\Advert;
use App\Entity\ImageGallery;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ImageUploadHandler
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ImageGalleryFormDTO $formDTO, User $user, Advert $advert = null)
    {
        $userImage = new ImageGallery();
        $userImage
            ->setImageFile($formDTO->getImageFile())
            ->setUser($user)
            ->setAdvert($advert)
            ->setMainPicture(false);
        $this->entityManager->persist($userImage);
        $this->entityManager->flush();
    }
}
