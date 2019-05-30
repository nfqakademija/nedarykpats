<?php

namespace App\Controller\Api;

use App\Entity\Advert;
use App\Form\FeedbackFormType;
use App\Handler\FeedbackCreationHandler;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{

    /**
     * @Route("api/feedback", name="api_feedback", requirements={"POST"})
     * @param Request $request
     * @param FeedbackCreationHandler $feedbackCreationHandler
     * @return Response
     * @throws Exception
     */
    public function newFeedback(Request $request, FeedbackCreationHandler $feedbackCreationHandler): Response
    {
        $feedbackDTOData = json_decode($request->getContent(), true);
        $advert = $this->getDoctrine()->getRepository(Advert::class)->find($feedbackDTOData['advert']);

        if ($advert->getUser() !== $this->getUser()) {
            $response = new Response(
                json_encode(['success' => false,]),
                Response::HTTP_FORBIDDEN
            );
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $feedbackForm = $this->createForm(FeedbackFormType::class);
        $feedbackForm->submit($feedbackDTOData);

        if ($feedbackForm->isSubmitted() && $feedbackForm->isValid()) {
            $feedbackDTO = $feedbackForm->getData();
            try {
                $result = $feedbackCreationHandler->handle($feedbackDTO);
                return new Response(json_encode(['success' => $result]));
            } catch (Exception $e) {
                $response = new Response(
                    json_encode(['success' => false,]),
                    Response::HTTP_BAD_REQUEST
                );
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        }

        $response = new Response(json_encode(['success' => false,]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
