<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
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
     * @ORM\JoinColumn(nullable=false)
     * @var Advert
     */
    private $advert;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     * @Assert\Email(message="Pateiktas neteisingas el. paštas", mode="loose")
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *     max="2000",
     *     min="30",
     *     maxMessage="Viršytas maksimalus kiekis",
     *     minMessage="Žinutėje per mažai simbolių"
     * )
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
     * @return bool
     */


    /**
     * Offer constructor.
     */
    public function __construct()
    {
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
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Offer
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getToken(): ?Token
    {
        return $this->token;
    }

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
}
