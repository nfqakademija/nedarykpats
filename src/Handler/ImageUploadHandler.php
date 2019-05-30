<?php

namespace App\Handler;

use App\DTO\ImageGalleryFormDTO;
use App\Entity\Advert;
use App\Entity\ImageGallery;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @throws \Exception
     */
    public function handle(ImageGalleryFormDTO $formDTO, User $user = null, Advert $advert = null)
    {
        /** @var UploadedFile $item */
        foreach ($formDTO->getImageFile() as $item) {
            $image = new ImageGallery();
            $image
                ->setImageFile($item)
                ->setUser($user)
                ->setAdvert($advert);
            $this->entityManager->persist($image);
        }
        $this->entityManager->flush();
    }
}
