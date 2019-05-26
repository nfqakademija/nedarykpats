<?php

namespace App\Twig;

use App\Entity\Advert;
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
     * @param Advert $advert
     * @return bool
     */
    public function showOfferForm(?User $user, Advert $advert): bool
    {
        if ($advert->getUser() === $user) {
            return false;
        }

        foreach ($advert->getOffers() as $offer) {
            if ($offer->getUser() === $user) {
                return false;
            }
        }

        return true;
    }
}
