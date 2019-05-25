<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class LoginFormDTO
{

    /**
     * @var string|null
     * @Assert\Email(message="Pateiktas neteisingas el. paštas", mode="loose")
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @var string|null
     * @Assert\Length(
     *     max="4096",
     *     min="6",
     * )
     */
    private $password;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return LoginFormDTO
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return LoginFormDTO
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }
}
