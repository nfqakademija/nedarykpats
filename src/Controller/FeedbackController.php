<?php

namespace App\Controller;

use App\DTO\FeedbackFormDTO;
use App\Form\FeedbackFormType;
use App\Handler\FeedbackCreationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{

    /**
     * @Route("api/feedback", name="feedback")
     * @param Request $request
     * @param FeedbackCreationHandler $feedbackCreationHandler
     * @return Response
     */
    public function newFeedback(Request $request, FeedbackCreationHandler $feedbackCreationHandler): Response
    {
        $feedbackForm = $this->createForm(FeedbackFormType::class);
        $feedbackDTOData = json_decode($request->getContent(), true);
        $feedbackForm->submit($feedbackDTOData);

        if ($feedbackForm->isSubmitted() && $feedbackForm->isValid()) {
            $feedbackDTO = $feedbackForm->getData();
            $result = $feedbackCreationHandler->handle($feedbackDTO);

            if ($result) {
                return (new Response(json_encode(['success' => true])));
            } else {
                return (new Response(json_encode(['success' => false])));
            }
        } else {
            return (new Response(json_encode(['success' => false])));
        }
    }
}
