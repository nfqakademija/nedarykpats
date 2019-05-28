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
            new TwigFunction('offerFormIsAvailable', [OfferRuntime::class, 'offerFormIsAvailable']),
            new TwigFunction('profileIsAppUsers', [UserRuntime::class, 'profileIsAppUsers']),
            new TwigFunction('cancelingOfferIsAvailable', [AdvertRuntime::class, 'cancelingOfferIsAvailable']),
            new TwigFunction('leavingFeedbackIsAvailable', [AdvertRuntime::class, 'leavingFeedbackIsAvailable']),
            new TwigFunction('getOfferStatus', [OfferRuntime::class, 'getOfferStatus']),
            new TwigFunction('approvingOfferIsAvailable', [AdvertRuntime::class, 'approvingOfferIsAvailable']),
            new TwigFunction('isOfferAccepted', [AdvertRuntime::class, 'isOfferAccepted']),
            new TwigFunction('isOfferDeclined', [AdvertRuntime::class, 'isOfferDeclined']),
        ];
    }
}
