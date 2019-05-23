<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\File;

class ImageGalleryFormDTO
{

    /**
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return ImageGalleryFormDTO
     */
    public function setImageFile(?File $imageFile): ImageGalleryFormDTO
    {
        $this->imageFile = $imageFile;
        return $this;
    }
}
