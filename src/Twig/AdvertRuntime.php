<?php

namespace App\Twig;

use App\Entity\Advert;
use App\Entity\Offer;
use App\Entity\User;
use Twig\Extension\RuntimeExtensionInterface;

class AdvertRuntime implements RuntimeExtensionInterface
{
    /**
     * @param User|null $loggedUser
     * @param Advert $advert
     * @param Offer $offer
     * @return bool
     */
    public function leavingFeedbackIsAvailable(?User $loggedUser, Offer $offer, Advert $advert): bool
    {
        if ($advert->getUser() !== $loggedUser) {
            return false;
        }

        if ($advert->getAcceptedOffer() === null) {
            return false;
        }

        if ($advert->getAcceptedOffer() !== $offer) {
            return false;
        }

        if ($advert->getFeedback() !== null) {
            return false;
        }

        return true;
    }

    /**
     * @param User|null $loggedUser
     * @param Offer $offer
     * @param Advert $advert
     * @return bool
     */
    public function cancelingOfferIsAvailable(?User $loggedUser, Offer $offer, Advert $advert): bool
    {
        if ($advert->getFeedback() !== null) {
            return false;
        }

        $availableForOfferAuthor = $offer->getUser() === $loggedUser;
        $availableForAdvertAuthor = $advert->getUser() === $loggedUser && $advert->getAcceptedOffer() === $offer;

        return $availableForAdvertAuthor || $availableForOfferAuthor;
    }

    /**
     * @param User|null $loggedUser
     * @param Advert $advert
     * @return bool
     */
    public function approvingOfferIsAvailable(?User $loggedUser, Advert $advert): bool
    {
        if ($advert->getUser() !== $loggedUser) {
            return false;
        }

        if ($advert->getAcceptedOffer()) {
            return false;
        }

        return true;
    }
}
