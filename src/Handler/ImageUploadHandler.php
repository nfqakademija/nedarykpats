<?php

namespace App\Handler;

use App\DTO\ImageGalleryFormDTO;
use App\Entity\Advert;
use App\Entity\ImageGallery;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ImageUploadHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ImageUploadHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ImageGalleryFormDTO $formDTO
     * @param User|null $user
     * @param Advert|null $advert
     */
    public function handle(ImageGalleryFormDTO $formDTO, User $user = null, Advert $advert = null)
    {
        $userImage = new ImageGallery();
        $userImage
            ->setImageFile($formDTO->getImageFile())
            ->setUser($user)
            ->setAdvert($advert);
        $this->entityManager->persist($userImage);
        $this->entityManager->flush();
    }
}
