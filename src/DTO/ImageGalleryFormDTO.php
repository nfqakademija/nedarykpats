<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ImageGalleryFormDTO
{

    /**
     *
     * @var UploadedFile[]
     * @Assert\All(
     *     @Assert\Image(
     *     maxSize="1024k",
     *     maxSizeMessage="Keliamas failas yra per didelis - ({{ size }} {{ suffix }}).",
     *     mimeTypes="image/*",
     *     mimeTypesMessage="Galima įkelti tik nuotraukas")
     *     )
     * )
     */
    private $imageFile;

    /**
     * @return UploadedFile[]
     */
    public function getImageFile(): ?array
    {
        return $this->imageFile;
    }

    /**
     * @param UploadedFile[] $imageFile
     * @return ImageGalleryFormDTO
     */
    public function setImageFile(?array $imageFile): ImageGalleryFormDTO
    {
        $this->imageFile = $imageFile;
        return $this;
    }
}
