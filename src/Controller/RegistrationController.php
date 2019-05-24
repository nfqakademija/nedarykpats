<?php

namespace App\Controller;

use App\DTO\RegistrationFormDTO;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Handler\RegistrationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
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

        $form = $this->createForm(RegistrationFormType::class);

        if ($request->query->get('email') != null) {
            $registrationFormDTO = new RegistrationFormDTO();
            $registrationFormDTO->setEmail($request->query->get('email'));
            $form = $this->createForm(RegistrationFormType::class, $registrationFormDTO);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var RegistrationFormDTO $registrationFormDTO */
            $registrationFormDTO = $form->getData();

            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findUserByEmail($registrationFormDTO->getEmail());

            if ($user instanceof User) {
                $this->addFlash(
                    'fail',
                    'Jau egzistuoja vartotojas tokiu el.paštu' . $user->getEmail()
                );
                $form->get('email')->addError(new FormError('Jau egzistuoja vartotojas tokiu el.paštu'));
            } else {
                $user = $registrationHandler->handle($registrationFormDTO);
                $email = $user->getEmail();

                $this->addFlash(
                    'success',
                    'Norėdami baigti registraciją, pasitikrinkite el. paštą ' . $email
                );

                return new RedirectResponse($this->generateUrl('home'));
            }
        }

        return $this->render('register/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
