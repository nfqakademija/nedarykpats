<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdvertRepository")
 */
class Advert
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=1000)
     * @var string
     */
    private $text;

    /**
     * @ORM\Column(type="datetime", nullable=FALSE)
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="adverts")
     * @JoinTable(name="adverts_categories")
     * @var ArrayCollection|Category
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offer", mappedBy="advert")
     * @var ArrayCollection|Offer
     */
    private $offers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="adverts")
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    private $user;



    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Token", mappedBy="advert", cascade={"persist", "remove"})
     */
    private $token;


    /**
     * Advert constructor.
     * @param \DateTime|null $createdAt
     * @throws \Exception
     */
    public function __construct(\DateTime $createdAt = null)
    {
        $this->categories = new ArrayCollection();
        $this->offers = new ArrayCollection();

        if (isset($createdAt)) {
            $this->createdAt = $createdAt;
        } else {
            $this->createdAt = new \DateTime('now');
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return Advert
     */
    public function setTitle(string $title): ?self
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
     * @return Advert
     */
    public function setText(string $text): ?self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Advert
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
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
     * @return Advert
     */
    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    /**
     * @param Category $category
     * @return Advert
     */
    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return Collection|Offer[]
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    /**
     * @param Offer $offer
     * @return Advert
     */
    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setAdvert($this);
        }

        return $this;
    }

    /**
     * @param Offer $offer
     * @return Advert
     */
    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->contains($offer)) {
            $this->offers->removeElement($offer);
            // set the owning side to null (unless already changed)
            if ($offer->getAdvert() === $this) {
                $offer->setAdvert(null);
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function countOffers()
    {
        return count($this->offers);
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return Advert
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    /**
     * @param bool $isConfirmed
     * @return Advert
     */
    public function setIsConfirmed(bool $isConfirmed): self
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    public function getToken(): ?Token
    {
        return $this->token;
    }

    public function setToken(?Token $token): self
    {
        $this->token = $token;

        // set (or unset) the owning side of the relation if necessary
        $newAdvert = $token === null ? null : $this;
        if ($newAdvert !== $token->getAdvert()) {
            $token->setAdvert($newAdvert);
        }

        return $this;
    }
}
