<?php

namespace App\Twig;

use App\Handler\FeedbackModalDisplayHandler;
use Symfony\Component\HttpFoundation\Request;
use Twig\Extension\RuntimeExtensionInterface;

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
     * @throws \Exception
     */
    public function isFeedbackAvailable(Request $request)
    {
        $result = false;
        if (!$request->cookies->get('FeedbackDisplayed')) {
            $result = $this->feedbackModalDisplayHandler->handleDataCheck();
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getDataForFeedback()
    {
        $result = $this->feedbackModalDisplayHandler->handleDataCollection();
        return $result;
    }
}
