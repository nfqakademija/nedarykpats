<?php

namespace App\DTO;

use App\Entity\City;

class ProfileDetailsDTO
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $lastName;

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
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return ProfileDetailsDTO
     */
    public function setLastName(?string $lastName): ProfileDetailsDTO
    {
        $this->lastName = $lastName;
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
