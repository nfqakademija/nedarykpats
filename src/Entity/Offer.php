<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="advert_user_idx", columns={"advert_id", "user_id"})})
 */
class Offer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Advert", inversedBy="offers")
     * @ORM\JoinColumn(nullable=true)
     * @var Advert
     */
    private $advert;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $text;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @var \DateTimeInterface
     */
    private $createdAt;


    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Token", mappedBy="offer", cascade={"persist", "remove"})
     */
    private $token;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRetracted;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeclined;
    


    /**
     * Offer constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->isDeclined = false;
        $this->isRetracted = false;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Advert|null
     */
    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    /**
     * @param Advert $advert
     * @return Offer
     */
    public function setAdvert(Advert $advert): self
    {
        $this->advert = $advert;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Offer
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return Offer
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
     * @return Offer
     */
    public function setIsConfirmed(bool $isConfirmed): self
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    /**
     * @return Token|null
     */
    public function getToken(): ?Token
    {
        return $this->token;
    }

    /**
     * @param Token|null $token
     * @return Offer
     */
    public function setToken(?Token $token): self
    {
        $this->token = $token;

        // set (or unset) the owning side of the relation if necessary
        $newOffer = $token === null ? null : $this;
        if ($newOffer !== $token->getOffer()) {
            $token->setOffer($newOffer);
        }

        return $this;
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
     * @return Offer
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsRetracted(): bool
    {
        return $this->isRetracted;
    }

    /**
     * @param bool $isRetracted
     * @return Offer
     */
    public function setIsRetracted(bool $isRetracted): self
    {
        $this->isRetracted = $isRetracted;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsDeclined(): bool
    {
        return $this->isDeclined;
    }

    /**
     * @param bool $isDeclined
     * @return Offer
     */
    public function setIsDeclined(bool $isDeclined): self
    {
        $this->isDeclined = $isDeclined;

        return $this;
    }
}
