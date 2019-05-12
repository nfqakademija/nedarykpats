<?php
namespace App\DTO;

use App\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;

class AdvertFormDTO
{

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $text;

    /**
     * @var ArrayCollection|Category
     */
    private $categories;

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
}
