<?php


namespace App\DTO;


use App\Entity\Advert;
use Symfony\Component\Validator\Constraints as Assert;

class OfferFormDTO
{

    /**
     * @var string
     * @Assert\Email(message="Pateiktas neteisingas el. paštas", mode="loose")
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @var Advert
     */
    private $advert;

    /**
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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return OfferFormDTO
     */
    public function setEmail(string $email): OfferFormDTO
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Advert
     */
    public function getAdvert(): Advert
    {
        return $this->advert;
    }

    /**
     * @param Advert $advert
     * @return OfferFormDTO
     */
    public function setAdvert(Advert $advert): OfferFormDTO
    {
        $this->advert = $advert;
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
     * @return OfferFormDTO
     */
    public function setText(string $text): OfferFormDTO
    {
        $this->text = $text;
        return $this;
    }
}