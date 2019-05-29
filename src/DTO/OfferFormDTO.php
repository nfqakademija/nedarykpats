<?php


namespace App\DTO;

use App\Entity\Advert;
use Symfony\Component\Validator\Constraints as Assert;

class OfferFormDTO
{

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string
     * @Assert\Email(message="Pateiktas neteisingas el. paštas", mode="loose")
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
     *     min="10",
     *     maxMessage="Viršytas maksimalus kiekis",
     *     minMessage="Žinutėje per mažai simbolių"
     * )
     */
    private $text;

    /**
     * @var bool
     */
    private $isRetracted;

    /**
     * @var bool
     */
    private $isDeclined;


    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return OfferFormDTO
     */
    public function setEmail(?string $email): OfferFormDTO
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Advert
     */
    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    /**
     * @param Advert $advert
     * @return OfferFormDTO
     */
    public function setAdvert(?Advert $advert): OfferFormDTO
    {
        $this->advert = $advert;
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
     * @return OfferFormDTO
     */
    public function setText(?string $text): OfferFormDTO
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return OfferFormDTO
     */
    public function setName(?string $name): OfferFormDTO
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return bool|null
     */
    public function getIsRetracted(): ?bool
    {
        return $this->isRetracted;
    }

    /**
     * @param bool|null $isRetracted
     * @return OfferFormDTO
     */
    public function setIsRetracted(?bool $isRetracted): self
    {
        $this->isRetracted = $isRetracted;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsDeclined(): ?bool
    {
        return $this->isDeclined;
    }

    /**
     * @param bool|null $isDeclined
     * @return OfferFormDTO
     */
    public function setIsDeclined(?bool $isDeclined): self
    {
        $this->isDeclined = $isDeclined;

        return $this;
    }
}
