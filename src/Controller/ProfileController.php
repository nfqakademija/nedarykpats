<?php

namespace App\Controller;

use App\Form\ProfileDetailsType;
use App\Handler\ProfileHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends AbstractController
{

    /**
     * @Route ("/profile" , name="profile")
     * @param Request $request
     * @param ProfileHandler $profileHandler
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, ProfileHandler $profileHandler)
    {
        $profileForm = $this->createForm(ProfileDetailsType::class);

        $profileForm->handleRequest($request);

        if ($profileForm->isSubmitted()) {
            $user = $this->getUser();

            $profileDetailsDTO = $profileForm->getData();

            $profileHandler->handle($user, $profileDetailsDTO);

            $this->addFlash('success', 'Profilis išsaugotas');

            return $this->redirect('/profile');
        }

        return $this->render('user/profile.html.twig', [
            'profileForm' => $profileForm->createView(),
        ]);
    }
}
