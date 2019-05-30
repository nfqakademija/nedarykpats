<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ImageGalleryFormDTO
{

    /**
     *
     * @var UploadedFile
     * @Assert\Image(
     *     maxSize="1024k",
     *     maxSizeMessage="Keliamas failas yra per didelis - ({{ size }} {{ suffix }}).",
     *     mimeTypes="image/*",
     *     mimeTypesMessage="Galima įkelti tik nuotraukas")
     */
    private $imageFile;

    /**
     * @return UploadedFile|null
     */
    public function getImageFile(): ?UploadedFile
    {
        return $this->imageFile;
    }

    /**
     * @param UploadedFile|null $imageFile
     * @return ImageGalleryFormDTO
     */
    public function setImageFile(UploadedFile $imageFile): ImageGalleryFormDTO
    {
        $this->imageFile = $imageFile;
        return $this;
    }
}
