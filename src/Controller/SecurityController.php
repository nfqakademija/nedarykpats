<?php

namespace App\Controller;

use App\Security\RegistrationHandler;
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
    public function loginExternal(Request $request, RegistrationHandler $registrationHandler)
    {
        $recipient = $request->request->get('email');
        var_dump($recipient);
        $registrationHandler->sendExternalLoginEmail($recipient);
        return $this->redirectToRoute('home');
    }

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
