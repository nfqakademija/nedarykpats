<?php

namespace App\DTO;

use App\Entity\Category;
use App\Entity\City;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;

class AdvertFormDTO
{

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
     * @var City
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @var ArrayCollection|Category
     * @Assert\NotBlank()
     */
    private $categories;

    /**
     * @var bool
     */
    private $isDeleted;

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * AdvertFormDTO constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
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
     * @return mixed
     */
    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }


    /**
     * @param $isDeleted
     * @return AdvertFormDTO
     */
    public function setIsDeleted($isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }
}
