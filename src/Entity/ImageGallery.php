<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageGalleryRepository")
 * @Vich\Uploadable
 */
class ImageGallery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @Vich\UploadableField(mapping="user_gallery", fileNameProperty="fileName", size="size")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Advert", inversedBy="images")
     */
    private $advert;

    /**
     * @ORM\Column(type="boolean")
     */
    private $mainPicture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $size;

    /**
     * @ORM\Column(type="array")
     */
    private $dimensions = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    public function setAdvert(?Advert $advert): self
    {
        $this->advert = $advert;

        return $this;
    }

    public function getMainPicture(): ?bool
    {
        return $this->mainPicture;
    }

    public function setMainPicture(bool $mainPicture): self
    {
        $this->mainPicture = $mainPicture;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getDimensions(): ?array
    {
        return $this->dimensions;
    }

    public function setDimensions(array $dimensions): self
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile(): File
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     * @return UserImageGallery
     */
    public function setImageFile(File $imageFile): self
    {
        $this->imageFile = $imageFile;
        return $this;
    }
}
