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
     * @ManyToMany(targetEntity="Category", inversedBy="adverts")
     * @JoinTable(name="adverts_categories")
     * @var array|Category
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
     */
    private $user;

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
     * @param Category[] $categories
     * @return Advert
     */
    public function setCategories(ArrayCollection $categories): ?self
    {
        $this->categories = $categories;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
