<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Handler\RegistrationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
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
            $email = $user->getEmail();

            $this->addFlash(
                'success',
                'Norėdami baigti registraciją, pasitikrinkite el. paštą ' . $email
            );

            return new RedirectResponse($this->generateUrl('home'));
        }

        return $this->render('register/register.html.twig', [
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
