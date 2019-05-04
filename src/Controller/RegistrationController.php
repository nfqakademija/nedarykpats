<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use App\Service\EmailService;
use App\Service\RegistrationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginAuthenticator $authenticator
     * @param RegistrationHandler $registrationHandler
     * @param EmailService $emailService
     * @return Response
     * @throws \Exception
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginAuthenticator $authenticator,
        RegistrationHandler $registrationHandler,
        EmailService $emailService
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->setUserProperties($user,  $passwordEncoder, $form);

            $this->sendRegistrationEmail($registrationHandler, $emailService, $request);

            $this->addFlash('success', 'Norit uzbaigti registracija patikrinkite emaila');

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
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
     * @param EmailService $emailService
     * @param Request $request
     * @throws \Exception
     */
    private function sendRegistrationEmail(
        RegistrationHandler $registrationHandler,
        EmailService $emailService,
        Request $request
    ) {
        $form = $request->request->all();
        $email = $form['registration_form']['email'];
        $hash = $registrationHandler->createLoginHash($email);
        $emailService->sendSingleLoginEmail($email, $hash);
    }

}
