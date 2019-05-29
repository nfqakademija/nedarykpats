<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('isFeedbackAvailable', [FeedbackRuntime::class, 'isFeedbackAvailable']),
            new TwigFunction('getDataForFeedback', [FeedbackRuntime::class, 'getDataForFeedback']),
            new TwigFunction('userHasDefinedName', [UserRuntime::class, 'userHasDefinedName']),
            new TwigFunction('profileIsAppUsers', [UserRuntime::class, 'profileIsAppUsers']),
            new TwigFunction('cancelingOfferIsAvailable', [AdvertRuntime::class, 'cancelingOfferIsAvailable']),
            new TwigFunction('leavingFeedbackIsAvailable', [AdvertRuntime::class, 'leavingFeedbackIsAvailable']),
            new TwigFunction('approvingOfferIsAvailable', [AdvertRuntime::class, 'approvingOfferIsAvailable']),
            new TwigFunction('isOfferAccepted', [AdvertRuntime::class, 'isOfferAccepted']),
            new TwigFunction('isOfferDeclined', [AdvertRuntime::class, 'isOfferDeclined']),
            new TwigFunction('displayOffer', [AdvertRuntime::class, 'displayOffer']),
            new TwigFunction('getOfferStatus', [OfferRuntime::class, 'getOfferStatus']),
            new TwigFunction('offerFormIsAvailable', [OfferRuntime::class, 'offerFormIsAvailable']),
        ];
    }
}
