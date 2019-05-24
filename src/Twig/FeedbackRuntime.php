<?php

namespace App\Twig;

use App\Handler\FeedbackModalDisplayHandler;
use Symfony\Component\HttpFoundation\Request;
use Twig\Extension\RuntimeExtensionInterface;
use App\Entity\User;
use App\Entity\Advert;

class FeedbackRuntime implements RuntimeExtensionInterface
{
    /**
     * @var FeedbackModalDisplayHandler
     */
    private $feedbackModalDisplayHandler;

    /**
     * FeedbackRuntime constructor.
     * @param FeedbackModalDisplayHandler $feedbackModalDisplayHandler
     */
    public function __construct(FeedbackModalDisplayHandler $feedbackModalDisplayHandler)
    {
        $this->feedbackModalDisplayHandler = $feedbackModalDisplayHandler;
    }


    /**
     * @param Request $request
     * @return bool
     */
    public function isFeedbackAvailable(Request $request)
    {
        $result = false;
        if (!$request->cookies->get('FeedbackDisplayed')) {
            $result = $this->feedbackModalDisplayHandler->handleDataCheck();
            var_dump($result);
        }
        return $result;
    }

    public function getDataForFeedback()
    {
        $result = $this->feedbackModalDisplayHandler->handleDataCollection();
        return $result;
    }


    /**
     * @param User $user
     * @param Advert $advert
     * @return bool
     */
    public function userHasNotSubmittedOffer(User $user, Advert $advert): bool
    {
        $users = [];
        foreach ($advert->getOffers() as $offer) {
            $users[] = $offer->getUser();
        }
        return !in_array($user, $users);
    }
}
