<?php

namespace App\Twig;

use App\Entity\Advert;
use App\Entity\Feedback;
use App\Entity\Offer;
use App\Entity\User;
use Twig\Extension\RuntimeExtensionInterface;

class OfferRuntime implements RuntimeExtensionInterface
{

    /**
     * @param Offer $offer
     * @param Advert $advert
     * @return string
     */
    public function getOfferStatus(Offer $offer, Advert $advert): string
    {
        if ($advert->getAcceptedOffer() === $offer && $advert->getFeedback() instanceof Feedback) {
            return 'Status-acceptedFeedback';
        } elseif ($advert->getAcceptedOffer() === $offer) {
            return 'Status-accepted';
        } elseif ($advert->getAcceptedOffer() instanceof Offer) {
            return 'Status-loose';
        } elseif ($offer->getIsDeclined()) {
            return 'Status-declined';
        } elseif ($offer->getIsRetracted()) {
            return 'Status-retracted';
        } else {
            return 'Status-pending';
        }
    }

    /**
     * @param User|null $user
     * @param Advert $advert
     * @return bool
     */
    public function offerFormIsAvailable(?User $user, Advert $advert): bool
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
