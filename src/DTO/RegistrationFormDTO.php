<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormDTO
{
    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @var string|null
     * @Assert\Length(
     *     max="4096",
     *     min="6",
     *     minMessage = "Jūsų slaptažodis turi turėti mažiausiai {{ limit }} simbolius",
     * )
     */
    private $plainPassword;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return RegistrationFormDTO
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     * @return RegistrationFormDTO
     */
    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }
}
