<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class ImageGalleryFormDTO
{

    /**
     *
     * @var File|null
     * @Assert\Image(
     *     maxSize="1024k",
     *     maxSizeMessage="Keliamas failas yra per didelis - ({{ size }} {{ suffix }}).",
     *     mimeTypes="image/*",
     *     mimeTypesMessage="Galima įkelti tik nuotraukas")
     */
    private $imageFile;

    /**
     * @var bool|null
     */
    private $mainPicture;

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

    /**
     * @return bool|null
     */
    public function isMainPicture(): ?bool
    {
        return $this->mainPicture;
    }

    /**
     * @param bool $mainPicture|null
     * @return ImageGalleryFormDTO
     */
    public function setMainPicture(?bool $mainPicture): ImageGalleryFormDTO
    {
        $this->mainPicture = $mainPicture;
        return $this;
    }
}
