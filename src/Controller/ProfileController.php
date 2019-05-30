<?php

namespace App\Controller;

use App\DataTransformer\UserToProfileDetailsDTO;
use App\DTO\ImageGalleryFormDTO;
use App\Entity\Feedback;
use App\Entity\ImageGallery;
use App\Entity\User;
use App\Form\ImageGalleryFormType;
use App\Form\ProfileDetailsType;
use App\Form\ProfilePasswordFormType;
use App\Handler\ImageRemovalHandler;
use App\Handler\ImageUploadHandler;
use App\Handler\ProfileDataChangeHandler;
use App\Handler\ProfilePasswordChangeHandler;
use App\Repository\CategoryRepository;
use App\Repository\FeedbackRepository;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{

    /**
     * @Route ("/profile" , name="profile")
     * @param Request $request
     * @param ProfileDataChangeHandler $profileHandler
     * @param ProfilePasswordChangeHandler $profilePasswordChangeHandler
     * @param CategoryRepository $categoryRepository
     * @param ImageUploadHandler $imageUploadHandler
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function index(
        Request $request,
        ProfileDataChangeHandler $profileHandler,
        ProfilePasswordChangeHandler $profilePasswordChangeHandler,
        CategoryRepository $categoryRepository,
        ImageUploadHandler $imageUploadHandler
    ) {
        /** @var User $user */
        $user = $this->getUser();
        $profileDetailsDTO = (new UserToProfileDetailsDTO)->transform($this->getUser());
        $profileDetailsForm = $this->createForm(ProfileDetailsType::class, $profileDetailsDTO);
        $profilePasswordForm = $this->createForm(ProfilePasswordFormType::class);

        $profileDetailsForm->handleRequest($request);
        $profilePasswordForm->handleRequest($request);

        if ($profilePasswordForm->isSubmitted() && $profilePasswordForm->isValid()) {
            $profilePasswordDTO = $profilePasswordForm->getData();

            $profilePasswordChangeHandler->handle($profilePasswordDTO);

            $this->addFlash('success', 'Profilio slaptažodis sėkmingai atnaujintas');
            return $this->redirectToRoute('profile');
        }

        if ($profileDetailsForm->isSubmitted() && $profileDetailsForm->isValid()) {
            $profileDetailsDTO = $profileDetailsForm->getData();
            $profileHandler->handle($profileDetailsDTO);
            $this->addFlash('success', 'Profilio duomenys atnaujinti');

            return $this->redirectToRoute('profile');
        }

        $rateArray = [];
        $rateAverage = 0;
        foreach ($this->getUser()->getFeedbacks() as $value) {
            $rateArray[] = $value->getScore();
        }

        if ($rateArray) {
            $rateAverage = array_sum($rateArray) / count($rateArray);
        }

        $imageUploadForm = $this->createForm(ImageGalleryFormType::class);
        $imageUploadForm->handleRequest($request);

        /** @var FeedbackRepository $feedbackRepository */
        $feedbackRepository = $this->getDoctrine()->getRepository(Feedback::class);

        /** @var Feedback[] $feedbacks */
        $feedbacks = $feedbackRepository->findByUser($user);

        if ($imageUploadForm->isSubmitted() && $imageUploadForm->isValid()) {
            /** @var ImageGalleryFormDTO $imageDTO */
            $imageDTO = $imageUploadForm->getData();
            $imageUploadHandler->handle($imageDTO, $this->getUser());
            return $this->redirectToRoute('profile');
        }

        return $this->render('user/profile.html.twig', [
            'profileDetailsForm' => $profileDetailsForm->createView(),
            'profilePasswordForm' => $profilePasswordForm->createView(),
            'profilesOwner' => $user,
            'feedbacks' => $feedbacks,
            'rateAverage' => $rateAverage,
            'topCategories' => $categoryRepository->findUsersTopCategoryTitles($user),
            'imageUploadForm' => $imageUploadForm->createView()
        ]);
    }

    /**
     * @Route("/profile/image/{id}/remove", name="profile_image_remove", requirements={"id"="\d+"})
     * @ParamConverter("imageGallery", class="App:ImageGallery")
     * @param ImageGallery $imageGallery
     * @param ImageRemovalHandler $imageRemovalHandler
     * @return RedirectResponse
     */
    public function removeImageFromGallery(ImageGallery $imageGallery, ImageRemovalHandler $imageRemovalHandler)
    {
        $user = $this->getUser();
        $imageRemovalHandler->handle($imageGallery, $user);
        return $this->redirectToRoute('profile');
    }


    /**
     * @Route ("/profile/{identification}" , name="user_profile", requirements={"identification"="[\w\-\d]+"})
     * @ParamConverter("user", class="App:User"))
     * @param User $user
     * @param CategoryRepository $categoryRepository
     * @return RedirectResponse|Response
     */
    public function showProfile(
        User $user,
        CategoryRepository $categoryRepository
    ) {
        if ($this->getUser() === $user) {
            return $this->redirectToRoute('profile');
        }

        $rateArray = [];
        $rateAverage = 0;
        foreach ($user->getFeedbacks() as $value) {
            $rateArray[] = $value->getScore();
        }

        if ($rateArray) {
            $rateAverage = array_sum($rateArray) / count($rateArray);
        }

        /** @var FeedbackRepository $feedbackRepository */
        $feedbackRepository = $this->getDoctrine()->getRepository(Feedback::class);

        /** @var Feedback[] $feedbacks */
        $feedbacks = $feedbackRepository->findByUser($user);

        return $this->render('user/profile.html.twig', [
            'profilesOwner' => $user,
            'feedbacks' => $feedbacks,
            'rateAverage' => $rateAverage,
            'topCategories' => $categoryRepository->findUsersTopCategoryTitles($user),
        ]);
    }
}
