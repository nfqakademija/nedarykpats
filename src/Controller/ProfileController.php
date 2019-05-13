<?php

namespace App\Controller;

use App\Form\ProfileDetailsType;
use App\Form\ProfilePasswordFormType;
use App\Handler\ProfileDataChangeHandler;
use App\Handler\ProfilePasswordChangeHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends AbstractController
{

    /**
     * @Route ("/profile" , name="profile")
     * @param Request $request
     * @param ProfileDataChangeHandler $profileHandler
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(
        Request $request,
        ProfileDataChangeHandler $profileHandler,
        ProfilePasswordChangeHandler $profilePasswordChangeHandler
    ) {
        $profileDetailsForm = $this->createForm(ProfileDetailsType::class, $this->getUser());
        $profilePasswordForm = $this->createForm(ProfilePasswordFormType::class);

        $profileDetailsForm->handleRequest($request);
        $profilePasswordForm->handleRequest($request);

        if ($profilePasswordForm->isSubmitted() && $profilePasswordForm->isValid()) {
            $profilePasswordDTO = $profilePasswordForm->getData();

            $success = $profilePasswordChangeHandler->handle($profilePasswordDTO);

            if ($success) {
                $this->addFlash('success', 'Profilio slaptažodis sėkmingai atnaujintas');
            } else {
                $this->addFlash('success', 'Pateikti slaptažodžiai nesutampa');
            }
            return $this->redirectToRoute('profile');
        }

        if ($profileDetailsForm->isSubmitted() && $profileDetailsForm->isValid()) {
            $profileDetailsDTO = $profileDetailsForm->getData();
            $profileHandler->handle($profileDetailsDTO);
            $this->addFlash('success', 'Profilio duomenys atnaujinti');

            return $this->redirectToRoute('profile');
        }

        return $this->render('user/profile.html.twig', [
            'profileDetailsForm' => $profileDetailsForm->createView(),
            'profilePasswordForm' => $profilePasswordForm->createView()
        ]);
    }
}
