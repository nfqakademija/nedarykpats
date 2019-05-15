<?php


namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ProfilePasswordDTO
{

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *     max="4096",
     *     min="6",
     *     minMessage = "Your password should be at least {{ limit }} characters",
     * )
     */
    private $newPassword;

    /**
     * @return string
     */
    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     * @return ProfilePasswordDTO
     */
    public function setNewPassword(?string $newPassword): ProfilePasswordDTO
    {
        $this->newPassword = $newPassword;
        return $this;
    }
}
