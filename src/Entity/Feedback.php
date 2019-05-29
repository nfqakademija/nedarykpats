<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FeedbackRepository")
 */
class Feedback
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Advert", inversedBy="feedback", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $advert;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="feedbacks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $receivingUser;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    /**
     * Feedback constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime('now'));
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
     * @return Feedback
     */
    public function setAdvert(Advert $advert): self
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getReceivingUser(): ?User
    {
        return $this->receivingUser;
    }

    /**
     * @param User|null $receivingUser
     * @return Feedback
     */
    public function setReceivingUser(?User $receivingUser): self
    {
        $this->receivingUser = $receivingUser;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * @param int $score
     * @return Feedback
     */
    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return Feedback
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

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
     * @return Feedback
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
