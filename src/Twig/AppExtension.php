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
            new TwigFunction('userHasNotSubmittedOffer', [UserRuntime::class, 'userHasNotSubmittedOffer']),
            new TwigFunction('offerFormIsAvailable', [UserRuntime::class, 'offerFormIsAvailable']),
            new TwigFunction('cancelingOfferIsAvailable', [UserRuntime::class, 'cancelingOfferIsAvailable']),
            new TwigFunction('leavingFeedbackIsAvailable', [AdvertRuntime::class, 'leavingFeedbackIsAvailable']),
        ];
    }
}
