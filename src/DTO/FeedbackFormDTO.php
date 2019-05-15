<?php


namespace App\DTO;

use App\Entity\Advert;

class FeedbackFormDTO
{
    /**
     * @var Advert|null
     */
    private $advert;

    /**
     * @var string|null
     */
    private $receivingUser;

    /**
     * @var string|null
     */
    private $score;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @return Advert|null
     */
    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    /**
     * @param Advert|null $advert
     * @return FeedbackFormDTO
     */
    public function setAdvert(?Advert $advert): FeedbackFormDTO
    {
        $this->advert = $advert;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReceivingUser(): ?string
    {
        return $this->receivingUser;
    }

    /**
     * @param string|null $receivingUser
     * @return FeedbackFormDTO
     */
    public function setReceivingUser(?string $receivingUser): FeedbackFormDTO
    {
        $this->receivingUser = $receivingUser;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getScore(): ?string
    {
        return $this->score;
    }

    /**
     * @param string|null $score
     * @return FeedbackFormDTO
     */
    public function setScore(?string $score): FeedbackFormDTO
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
     * @return FeedbackFormDTO
     */
    public function setMessage(?string $message): FeedbackFormDTO
    {
        $this->message = $message;
        return $this;
    }
}
