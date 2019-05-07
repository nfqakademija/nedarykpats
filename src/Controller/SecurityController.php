<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Handler\SingleUseLoginHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Token;
use App\Service\TokenConsumerService;

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

        $form = $this->createForm(RegistrationFormType::class);

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'registrationForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/login-external", name="login_external")
     */
    public function loginExternal(
        Request $request,
        SingleUseLoginHandler $singleUseLoginHandler
    ) {
        $recipient = $request->request->get('email');
        $singleUseLoginHandler->handle($recipient);
        return $this->redirectToRoute('home');
    }


    /**
     * @Route("/auth/{hash}", name="token")
     * @ParamConverter("token", class="App:Token")
     * @param Token $token
     * @param TokenConsumerService $tokenConsumerService
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function validateFromEmail(Token $token, TokenConsumerService $tokenConsumerService, Request $request)
    {
        if ($tokenConsumerService->checkIfExpired($token)) {
            $this->addFlash('fail', 'Nuoroda nebegalioja.');
            return $this->redirectToRoute('home');
        }

        $result = $tokenConsumerService->consume($token, $request);

        switch ($result['EntityConfirmed']) {
            case 'User':
                $this->addFlash('success', 'Registracija sėkminga!');
                return $this->redirectToRoute('home');

            case 'Advert':
                $this->addFlash('success', 'Skelbimas patalpintas sėkmingai');
                return $this->redirectToRoute('/advert/'. $result['id']);

            case 'Offer':
                $this->addFlash('success', 'Siūlymas patalpintas sėkmingai');
                return $this->redirectToRoute('/advert/'. $result['advertId']);

            default:
                $this->addFlash('fail', 'Atsiprašome, neteisinga nuoroda');
                return $this->redirectToRoute('home');
        }
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
            $this->addFlash('fail', 'Atsiprašome, neteisingas prisijungimas');
            return $this->redirectToRoute('home');
        } else {
            $userEmail = $this->getUser()->getEmail();
            $user = substr($userEmail, 0, strpos($userEmail, "@"));

            $this->addFlash('success', 'Sveiki, '. $user);
            return $this->redirectToRoute('home');
        }
    }
}
