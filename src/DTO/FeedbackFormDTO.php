<?php


namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class FeedbackFormDTO
{
    /**
     * @var int|null
     * @Assert\NotBlank
     */
    private $advert;

    /**
     * @var int|null
     * @Assert\NotBlank
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
