<?php

namespace App\Twig;

use App\Entity\User;
use Twig\Extension\RuntimeExtensionInterface;

class UserRuntime implements RuntimeExtensionInterface
{
    /**
     * @param User|null $user
     * @param User $profileOwner
     * @return bool
     */
    public function profileIsAppUsers(?User $user, User $profileOwner): bool
    {
        return ($user === $profileOwner) ? true : false;
    }


    /**
     * @param User|null $user
     * @return bool
     */
    public function userHasDefinedName(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        if ($user->getName() === null) {
            return false;
        }
        return true;
    }
}
