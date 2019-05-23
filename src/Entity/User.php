<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @var string
     * @Assert\Email(message="Pateiktas neteisingas el. paštas", mode="loose")
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @var array
     */
    private $roles = [];


    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $name;


    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advert", mappedBy="user", orphanRemoval=true)
     */
    private $adverts;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Token", mappedBy="user", cascade={"persist", "remove"})
     */
    private $token;


    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $googleID;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offer", mappedBy="user", orphanRemoval=true)
     */
    private $offers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     * @ORM\JoinColumn(nullable=true)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feedback", mappedBy="receivingUser")
     */
    private $feedbacks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImageGallery", mappedBy="user", orphanRemoval=true)
     */
    private $images;

    /**
     * User constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->adverts = new ArrayCollection();
        $this->createdAt = new \DateTime('now');
        $this->offers = new ArrayCollection();
        $this->feedbacks = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(?string $name): User
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return User
     */
    public function setDescription(string $description): User
    {
        $this->description = $description;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Advert[]
     */
    public function getAdverts(): Collection
    {
        return $this->adverts;
    }

    /**
     * @param Advert $advert
     * @return User
     */
    public function addAdvert(Advert $advert): self
    {
        if (!$this->adverts->contains($advert)) {
            $this->adverts[] = $advert;
            $advert->setUser($this);
        }

        return $this;
    }

    /**
     * @param Advert $advert
     * @return User
     */
    public function removeAdvert(Advert $advert): self
    {
        if ($this->adverts->contains($advert)) {
            $this->adverts->removeElement($advert);
            // set the owning side to null (unless already changed)
            if ($advert->getUser() === $this) {
                $advert->setUser(null);
            }
        }

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
     * @return User
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
     * @param Token $token
     * @return User
     */
    public function setToken(Token $token): self
    {
        $this->token = $token;

        // set the owning side of the relation if necessary
        if ($this !== $token->getUser()) {
            $token->setUser($this);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGoogleID(): ?string
    {
        return $this->googleID;
    }

    /**
     * @param string|null $googleID
     * @return User
     */
    public function setGoogleID(?string $googleID): self
    {
        $this->googleID = $googleID;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

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
     * @return User
     */
    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setUser($this);
        }

        return $this;
    }

    /**
     * @param Offer $offer
     * @return User
     */
    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->contains($offer)) {
            $this->offers->removeElement($offer);
            // set the owning side to null (unless already changed)
            if ($offer->getUser() === $this) {
                $offer->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return City|null
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @param City|null $city
     * @return User
     */
    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Feedback[]
     */
    public function getFeedbacks(): Collection
    {
        return $this->feedbacks;
    }

    /**
     * @param Feedback $feedback
     * @return User
     */
    public function addFeedback(Feedback $feedback): self
    {
        if (!$this->feedbacks->contains($feedback)) {
            $this->feedbacks[] = $feedback;
            $feedback->setReceivingUser($this);
        }

        return $this;
    }

    /**
     * @param Feedback $feedback
     * @return User
     */
    public function removeFeedback(Feedback $feedback): self
    {
        if ($this->feedbacks->contains($feedback)) {
            $this->feedbacks->removeElement($feedback);
            // set the owning side to null (unless already changed)
            if ($feedback->getReceivingUser() === $this) {
                $feedback->setReceivingUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ImageGallery[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ImageGallery $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setUser($this);
        }

        return $this;
    }

    public function removeImage(ImageGallery $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getUser() === $this) {
                $image->setUser(null);
            }
        }

        return $this;
    }
}
