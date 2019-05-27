<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\City;

class ProfileDetailsDTO
{

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var City
     */
    private $city;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ProfileDetailsDTO
     */
    public function setName(?string $name): ProfileDetailsDTO
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
     * @return ProfileDetailsDTO
     */
    public function setDescription(?string $description): ProfileDetailsDTO
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return City
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @param City $city
     * @return ProfileDetailsDTO
     */
    public function setCity(?City $city): ProfileDetailsDTO
    {
        $this->city = $city;
        return $this;
    }
}
