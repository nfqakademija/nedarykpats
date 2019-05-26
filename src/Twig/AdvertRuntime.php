<?php

namespace App\Twig;

use App\Entity\Advert;
use App\Entity\Offer;
use Twig\Extension\RuntimeExtensionInterface;

class AdvertRuntime implements RuntimeExtensionInterface
{

    /**
     * @param Advert $advert
     * @param Offer $offer
     * @return bool
     */
    public function leavingFeedbackIsAvailable(Advert $advert, Offer $offer): bool
    {

        if ($advert->getAcceptedOffer() === null) {
            return false;
        }

        if ($advert->getAcceptedOffer() !== $offer) {
            return false;
        }

        if ($advert->getFeedback() === null) {
            return false;
        }

        return true;
    }
}
