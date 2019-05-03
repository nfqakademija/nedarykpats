<?php

namespace App\Controller;

use App\Service\RegistrationHandler;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
 * @Route("/login", name="login")
 */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/login-external", name="login_external")
     */
    public function loginExternal(
        Request $request,
        RegistrationHandler $registrationHandler,
        EmailService $emailService
    ) {
        $recipient = $request->request->get('email');
        $hash = $registrationHandler->createLoginHash($recipient);
        $emailService->sendSingleLoginEmail($recipient, $hash);

        return $this->redirectToRoute('home');
    }

//    /**
//     * @Route("/auth/{hash}", name="token")
//     * @ParamConverter("token", class="App:Token")
//     * @param Token $token
//     * @param RegistrationHandler $registrationHandler
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function validateFromEmail(Token $token, RegistrationHandler $registrationHandler)
//    {
//       $hash = $token->getHash();
//
//       if ($hash  && $token->getExpired() === false) {
//
//            $validation = $registrationHandler->validateToken($hash) ;
//
//            if ($validation) {
//
//
//
//                return $this->redirectToRoute('home');
//            }
//       }
//        return $this->redirectToRoute('home'); ///TODO: bad token url
//    }

    /**
     *
     * @Route("/connect/google", name="connect_google")
     * @param ClientRegistry $clientRegistry
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect();
    }

    /**
     *
     * @Route("/connect/google/check", name="connect_google_check")
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectCheckAction()
    {
        if (!$this->getUser()) {
            //TODO: Reikėtų pranešti apie nepavykusį prisijungimą
            return $this->redirectToRoute('home');
        } else {
            //TODO: Reikėtų pranešti apie pavykusį prisijungimą
            return $this->redirectToRoute('home');
        }
    }
}
