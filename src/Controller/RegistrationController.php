<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use App\Service\EmailHandler;
use App\Service\RegistrationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler    $guardHandler
     * @param LoginAuthenticator           $authenticator
     * @param RegistrationHandler          $registrationHandler
     * @param EmailHandler                 $emailService
     *
     * @return Response
     * @throws \Exception
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginAuthenticator $authenticator,
        RegistrationHandler $registrationHandler,
        EmailHandler $emailService
    ): Response {

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->setUserProperties($user, $passwordEncoder, $form);

            $this->sendRegistrationEmail($registrationHandler, $emailService, $request);

            $this->addFlash(
                'success',
                'Norėdami baigti registraciją, paspauskite ant nuorodos, išsiųstos pateiktu el. paštu'
            );

            return new RedirectResponse($this->generateUrl('home'));
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    /**
     * @param User $user
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param $form
     * @throws \Exception
     */
    private function setUserProperties(User $user, UserPasswordEncoderInterface $passwordEncoder, $form)
    {
         $user->setPassword(
             $passwordEncoder->encodePassword(
                 $user,
                 $form->get('plainPassword')->getData()
             )
         );

         $user->setIsConfirmed(false);
         $user->setCreatedAt(new \DateTime('now'));
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($user);
         $entityManager->flush();
    }

    /**
     * @param RegistrationHandler $registrationHandler
     * @param EmailHandler        $emailService
     * @param Request             $request
     *
     * @throws \Exception
     */
    private function sendRegistrationEmail(
        RegistrationHandler $registrationHandler,
        EmailHandler $emailService,
        Request $request
    ) {
        $form = $request->request->all();
        $email = $form['registration_form']['email'];
        $hash = $registrationHandler->createLoginHash($email);
        $emailService->sendSingleLoginEmail($email, $hash);
    }
}
