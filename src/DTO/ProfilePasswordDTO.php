<?php


namespace App\DTO;

class ProfilePasswordDTO
{
    /**
     * @var string
     */
    private $oldPassword;

    /**
     * @var string
     */
    private $newPassword;

    /**
     * @return string
     */
    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    /**
     * @param string $oldPassword
     * @return ProfilePasswordDTO
     */
    public function setOldPassword(?string $oldPassword): ProfilePasswordDTO
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

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
