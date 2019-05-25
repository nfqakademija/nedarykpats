<?php

namespace App\Twig;

use App\Entity\User;
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
            new TwigFunction('advertIsNotUsers', [UserRuntime::class, 'advertIsNotUsers']),
            new TwigFunction('profileIsAppUsers', [UserRuntime::class, 'profileIsAppUsers'])
        ];
    }
}
