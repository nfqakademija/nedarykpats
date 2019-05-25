<?php

namespace App\Twig;

use App\Entity\Advert;
use App\Entity\User;
use Twig\Extension\RuntimeExtensionInterface;

class UserRuntime implements RuntimeExtensionInterface
{
    /**
     * @param User $user
     * @param Advert $advert
     * @return bool
     */
    public function userHasNotSubmittedOffer(?User $user, Advert $advert): bool
    {
        foreach ($advert->getOffers() as $offer) {
            if ($offer->getUser() === $user) {
                return false;
            }
        }
        return true;
    }


    /**
     * @param User $user
     * @param Advert $advert
     * @return bool
     */
    public function advertIsNotUsers(?User $user, Advert $advert): bool
    {
        if ($advert->getUser() === $user) {
            return false;
        }
        return true;
    }
}
