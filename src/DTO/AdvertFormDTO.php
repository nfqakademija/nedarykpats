<?php


namespace App\DTO;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

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
     * Advert constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        //TODO:
        $this->categories = $entityManager->getRepository(Category::class)->findAll();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return AdvertFormDTO
     */
    public function setTitle(string $title): AdvertFormDTO
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return AdvertFormDTO
     */
    public function setText(string $text): AdvertFormDTO
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     * @return AdvertFormDTO
     */
    public function addCategory(Category $category): AdvertFormDTO
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
    public function removeCategory(Category $category): AdvertFormDTO
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return AdvertFormDTO
     */
    public function setEmail(string $email): AdvertFormDTO
    {
        $this->email = $email;
        return $this;
    }

}