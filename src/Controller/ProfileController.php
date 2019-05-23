<?php

namespace App\Controller;

use App\DataTransformer\UserToProfileDetailsDTO;
use App\Form\ProfileDetailsType;
use App\Entity\User;
use App\Form\ProfilePasswordFormType;
use App\Handler\ProfileDataChangeHandler;
use App\Handler\ProfilePasswordChangeHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;

class ProfileController extends AbstractController
{

    /**
     * @Route ("/profile/{id}" , name="profile", requirements={"id"="\d+"})
     * @ParamConverter("user", class="App:User"))
     * @param User $user
     * @param Request $request
     * @param ProfileDataChangeHandler $profileHandler
     * @param ProfilePasswordChangeHandler $profilePasswordChangeHandler
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(
        User $user,
        Request $request,
        ProfileDataChangeHandler $profileHandler,
        ProfilePasswordChangeHandler $profilePasswordChangeHandler,
        CategoryRepository $categoryRepository
    ) {

        $profileDetailsDTO = (new UserToProfileDetailsDTO)->transform($this->getUser());
        $profileDetailsForm = $this->createForm(ProfileDetailsType::class, $profileDetailsDTO);
        $profilePasswordForm = $this->createForm(ProfilePasswordFormType::class);

        $profileDetailsForm->handleRequest($request);
        $profilePasswordForm->handleRequest($request);

        if ($profilePasswordForm->isSubmitted() && $profilePasswordForm->isValid()) {
            $profilePasswordDTO = $profilePasswordForm->getData();

            $profilePasswordChangeHandler->handle($profilePasswordDTO);

            $this->addFlash('success', 'Profilio slaptažodis sėkmingai atnaujintas');
            return $this->redirectToRoute('profile', ['id' => $user->getId()]);
        }

        if ($profileDetailsForm->isSubmitted() && $profileDetailsForm->isValid()) {
            $profileDetailsDTO = $profileDetailsForm->getData();
            $profileHandler->handle($profileDetailsDTO);
            $this->addFlash('success', 'Profilio duomenys atnaujinti');

            return $this->redirectToRoute('profile', ['id' => $user->getId()]);
        }
        
        $rateArray = [];
        $rateAverage = 0;
        foreach ($this->getUser()->getFeedbacks() as $value) {
            $rateArray[] = $value->getScore();
        }

        if ($rateArray) {
            $rateAverage = array_sum($rateArray) / count($rateArray);
        }

        return $this->render('user/profile.html.twig', [
            'profileDetailsForm' => $profileDetailsForm->createView(),
            'profilePasswordForm' => $profilePasswordForm->createView(),
            'user' => $user,
            'rateAverage' => $rateAverage,
            'topCategories' => $categoryRepository->findUsersTopCategoryTitles($user),
        ]);
    }
}
