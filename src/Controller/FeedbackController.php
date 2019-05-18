<?php

namespace App\Controller;

use App\DTO\FeedbackFormDTO;
use App\Form\FeedbackFormType;
use App\Handler\FeedbackCreationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{

    /**
     * @Route("api/feedback", name="feedback", requirements={"POST"})
     * @param Request $request
     * @param FeedbackCreationHandler $feedbackCreationHandler
     * @return Response
     * @throws \Exception
     */
    public function newFeedback(Request $request, FeedbackCreationHandler $feedbackCreationHandler): Response
    {
        $feedbackForm = $this->createForm(FeedbackFormType::class);
        $feedbackDTOData = json_decode($request->getContent(), true);
        $feedbackForm->submit($feedbackDTOData);

        if ($feedbackForm->isSubmitted() && $feedbackForm->isValid()) {
            $feedbackDTO = $feedbackForm->getData();
            //TODO: prideti try catch,meta 500 jei negeri duomenys arba invalidi forma
            //TODO: erroras,jei dublouojasi ir jei toks vartotojas neegzistuoja
            try {
                $result = $feedbackCreationHandler->handle($feedbackDTO);
                if ($result) {
                    return (new Response(json_encode(['success' => true])));
                }
            } catch (\Exception $e) {
                return (new Response(
                    json_encode(['success' => false, 'Error' => $e->getMessage()]),
                    Response::HTTP_BAD_REQUEST
                ));
            }

            return (new Response(
                json_encode(['success' => false, 'Error' => 'Empty data']),
                Response::HTTP_BAD_REQUEST
            ));
        }

        return (new Response(json_encode(['success' => false, 'Error' => 'Invalid form']), Response::HTTP_BAD_REQUEST));
    }
}
