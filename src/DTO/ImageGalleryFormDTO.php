<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ImageGalleryFormDTO
{

    /**
     *
     * @var UploadedFile[]
     * @Assert\Count(min="1", minMessage="Būtina pasirinkti bent vieną failą")
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
