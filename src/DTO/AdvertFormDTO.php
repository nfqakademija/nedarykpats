<?php

namespace App\DTO;

use App\Entity\Category;
use App\Entity\City;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class AdvertFormDTO
{

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *     max="100",
     *     maxMessage="Viršytas maksimalus raidžių kiekis"
     * )
     */
    private $name;

    /**
     * @var string
     * @Assert\Email(message="Pateiktas neteisingas el. paštas", mode="loose")
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *     max="150",
     *     min="5",
     *     maxMessage="Viršytas maksimalus kiekis",
     *     minMessage="Pavadinime per mažai simbolių"
     * )
     */
    private $title;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *     max="2000",
     *     min="10",
     *     maxMessage="Viršytas maksimalus kiekis",
     *     minMessage="Žinutėje per mažai simbolių"
     * )
     */
    private $text;

    /**
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
    private $imageGallery;

    /**
     * @var City
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @var ArrayCollection|Category[]
     * @Assert\Count(min="1", minMessage="Būtina pasirinkti kategoriją")
     */
    private $categories;

    /**
     * @var bool
     */
    private $isDeleted;

    /**
     * AdvertFormDTO constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return AdvertFormDTO
     */
    public function setTitle(?string $title): AdvertFormDTO
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return AdvertFormDTO
     */
    public function setText(?string $text): AdvertFormDTO
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return City
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @param City $city
     * @return AdvertFormDTO
     */
    public function setCity(?City $city): AdvertFormDTO
    {
        $this->city = $city;
        return $this;
    }


    /**
     * @return ArrayCollection|Category[]
     */
    public function getCategories(): ?ArrayCollection
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     * @return AdvertFormDTO
     */
    public function addCategory(?Category $category): AdvertFormDTO
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    /**
     * @param Category $category
     * @return AdvertFormDTO
     */
    public function removeCategory(?Category $category): AdvertFormDTO
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return AdvertFormDTO
     */
    public function setEmail(?string $email): AdvertFormDTO
    {
        $this->email = $email;
        return $this;
    }


    /**
     * @return bool|null
     */
    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }


    /**
     * @param bool $isDeleted
     * @return AdvertFormDTO
     */
    public function setIsDeleted(bool $isDeleted): AdvertFormDTO
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return UploadedFile[]
     */
    public function getImageGallery(): ?array
    {
        return $this->imageGallery;
    }

    /**
     * @param UploadedFile[] $imageGallery
     * @return AdvertFormDTO
     */
    public function setImageGallery(?array $imageGallery): AdvertFormDTO
    {
        $this->imageGallery = $imageGallery;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return AdvertFormDTO
     */
    public function setName(string $name): AdvertFormDTO
    {
        $this->name = $name;
        return $this;
    }
}
