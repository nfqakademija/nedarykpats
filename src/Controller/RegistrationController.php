<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use App\Service\EmailHandler;
use App\Handler\RegistrationHandler;
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
     * @param RegistrationHandler          $registrationHandler
     *
     * @return Response
     * @throws \Exception
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        RegistrationHandler $registrationHandler
    ): Response {

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->setUserProperties($user, $passwordEncoder, $form);

            $registrationHandler->handle($user);

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
         $user->setRoles(['ROLE_USER']);
         $user->setIsConfirmed(false);
         $user->setCreatedAt(new \DateTime('now'));
    }
}
