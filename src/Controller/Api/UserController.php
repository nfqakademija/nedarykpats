<?php

namespace App\Controller\Api;

use App\DTO\LoginFormDTO;
use App\Entity\User;
use App\Form\LoginEmailStepFormType;
use App\Form\RegistrationFormType;
use App\Handler\RegistrationHandler;
use App\Handler\SingleUseLoginHandler;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @Route("api/public/user", name="api_get_user", methods={"GET"})
     * @param Request $request
     * @return Response
     * @throws NonUniqueResultException
     */
    public function checkUser(Request $request): Response
    {
        $loginDTOData = $request->query->all();
        $loginForm = $this->createForm(LoginEmailStepFormType::class);
        $loginForm->submit($loginDTOData);

        if ($loginForm->isSubmitted() && $loginForm->isValid()) {
            /** @var LoginFormDTO $loginDTO */
            $loginDTO = $loginForm->getData();
            try {
                $user = $this->getDoctrine()->getRepository(User::class)->findUserByEmail($loginDTO->getEmail());

                if ($user instanceof User) {
                    $authenticateUsingPassword = false;
                    if ($user->getPassword() !== null && strlen($user->getPassword()) > 0) {
                        $authenticateUsingPassword = true;
                    }
                    return new Response(json_encode(['authenticateUsingPassword' => $authenticateUsingPassword,]));
                } else {
                    return new Response('', Response::HTTP_NOT_FOUND);
                }
            } catch (Exception $e) {
                return new Response('', Response::HTTP_BAD_REQUEST);
            }
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("api/public/user/login", name="api_login", methods={"POST"})
     * @return Response
     */
    public function login(): Response
    {
        //Login handled in LoginAuthenticator
        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("api/public/user/send_login_link", name="api_send_login_link", methods={"POST"})
     * @param Request $request
     * @param SingleUseLoginHandler $singleUseLoginHandler
     * @return Response
     * @throws \Exception
     */
    public function sendLoginLink(Request $request, SingleUseLoginHandler $singleUseLoginHandler): Response
    {
        $loginDTOData = json_decode($request->getContent(), true);
        $loginForm = $this->createForm(LoginEmailStepFormType::class);
        $loginForm->submit($loginDTOData);

        if ($loginForm->isSubmitted() && $loginForm->isValid()) {
            /** @var LoginFormDTO $loginDTO */
            $loginDTO = $loginForm->getData();
            try {
                $result = $singleUseLoginHandler->handle($loginDTO->getEmail());
                if ($result) {
                    return new Response(
                        json_encode(['loginLinkSent' => true, 'email' => $loginDTO->getEmail()]),
                        Response::HTTP_OK
                    );
                }
            } catch (Exception $e) {
                return new Response(
                    json_encode(['loginLinkSent' => false,]),
                    Response::HTTP_BAD_REQUEST
                );
            }
        }
        return new Response(
            json_encode(['loginLinkSent' => false, 'email' => $loginDTOData['email']]),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("api/public/user", name="api_register", methods={"POST"})
     * @param Request $request
     * @param RegistrationHandler $registrationHandler
     * @return Response
     * @throws \Exception
     */
    public function register(
        Request $request,
        RegistrationHandler $registrationHandler
    ): Response {
        $registrationDTOData = json_decode($request->getContent(), true);

        $form = $this->createForm(RegistrationFormType::class);
        $form->submit($registrationDTOData);

        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findUserByEmail($registrationDTOData['email']);

        if ($user instanceof User) {
            return new Response(
                json_encode(['userCreated' => false, 'email' => $registrationDTOData['email']]),
                Response::HTTP_UNAUTHORIZED
            );
        }

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $registrationFormDTO = $form->getData();
                $user = $registrationHandler->handle($registrationFormDTO);
                $email = $user->getEmail();
                return new Response(
                    json_encode(['userCreated' => true, 'email' => $email]),
                    Response::HTTP_UNAUTHORIZED
                );
            } catch (Exception $e) {
                return new Response(
                    json_encode(['userCreated' => false,]),
                    Response::HTTP_BAD_REQUEST
                );
            }
        }
        return new Response(json_encode(['userCreated' => false,], Response::HTTP_BAD_REQUEST));
    }
}
