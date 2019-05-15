<?php


namespace App\DTO;

use App\Entity\Advert;
use App\Entity\User;

class FeedbackFormDTO
{
    /**
     * @var int|null
     */
    private $advert;

    /**
     * @var int|null
     */
    private $receivingUser;

    /**
     * @var int|null
     */
    private $score;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @return int|null
     */
    public function getAdvert(): ?int
    {
        return $this->advert;
    }

    /**
     * @param int|null $advert
     * @return FeedbackFormDTO
     */
    public function setAdvert(?int $advert): FeedbackFormDTO
    {
        $this->advert = $advert;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getReceivingUser(): ?int
    {
        return $this->receivingUser;
    }

    /**
     * @param int|null $receivingUser
     * @return FeedbackFormDTO
     */
    public function setReceivingUser(?int $receivingUser): FeedbackFormDTO
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
     * @param int|null $score
     * @return FeedbackFormDTO
     */
    public function setScore(?int $score): FeedbackFormDTO
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
