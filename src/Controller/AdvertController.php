<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Handler\UserRetrieveHandler;
use App\Helpers\PaginationHelper;
use App\Entity\Advert;
use App\Entity\User;
use App\Form\AdvertType;
use App\Form\OfferType;
use App\Handler\AdvertCreationHandler;
use App\Handler\AdvertRemovalHandler;
use App\Handler\OfferCreationHandler;
use App\Repository\AdvertRepository;
use App\Repository\CategoryRepository;
use App\Repository\ImageGalleryRepository;
use App\Repository\OfferRepository;
use App\SearchObjects\Filters;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvertController extends AbstractController
{

    /**
     * @Route ("/advert" , name="new_advert")
     * @param Request $request
     * @param AdvertCreationHandler $advertCreationHandler
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function addNewAdvert(Request $request, AdvertCreationHandler $advertCreationHandler)
    {
        $advertForm = $this->createForm(AdvertType::class);

        $advertForm->handleRequest($request);

        if ($advertForm->isSubmitted() && $advertForm->isValid()) {
            $advertFormDTO = $advertForm->getData();
            $advert = $advertCreationHandler->handle($advertFormDTO);
            $email = $advertFormDTO->getEmail();

            if ($advert->isConfirmed()) {
                $this->addFlash('success', 'Pateikta užklausa sėkmingai išsaugota');
            } else {
                $this->addFlash('success', 'Jums išsiųstas patvirtinimo laiškas šiuo el. paštu ' . $email);
            }

            return $this->redirect('/advert/' . $advert->getid());
        }

        return $this->render('advert/insert_advert.html.twig', [
            'advertForm' => $advertForm->createView(),
        ]);
    }

    /**
     * @Route("/advert/{id}", name="advert", requirements={"id"="\d+"})
     * @ParamConverter("advert", class="App:Advert")
     * @param Advert $advert
     * @param Request $request
     * @param OfferCreationHandler $offerCreationHandler
     * @return Response
     * @throws Exception
     */
    public function advert(
        Advert $advert,
        Request $request,
        OfferCreationHandler $offerCreationHandler,
        UserRetrieveHandler $userRetrieveHandler
    ) {
        $offerForm = $this->createForm(OfferType::class);

        $offerForm->handleRequest($request);

        /** @var OfferRepository $offer */
        $offerRepository = $this->getDoctrine()->getRepository(Offer::class);

        $offers = $offerRepository->findByAdvert($advert);

        if ($offerForm->isSubmitted()
            && $offerForm->isValid()
            && $this->offerFormIsAvailable($this->getUser(), $advert)
        ) {
            try {
                $offerFormDTO = $offerForm->getData();
                $offerFormDTO->setAdvert($advert);
                $offer = $offerCreationHandler->handle($offerFormDTO);
                $email = $offerFormDTO->getEmail();

                if ($offer->isConfirmed()) {
                    $this->addFlash('success', 'Pateikta užklausa sėkmingai išsaugota');
                } else {
                    $this->addFlash('success', 'Jums išsiųstas patvirtinimo laiškas šiuo el. paštu ' . $email);
                }
            } catch (Exception $exception) {
                $this->addFlash('fail', 'Įvyko klaida. Siūlymo patalpinti nepavyko.');
            }
            return $this->redirect($request->getUri());
        }

        return $this->render('advert/single_advert.html.twig', [
            'advert' => $advert,
            'offers' => $offers,
            'offerForm' => $offerForm->createView()
        ]);
    }

    /**
     * @Route("/my-adverts", name="my_adverts")
     * @param Request $request
     * @param AdvertRepository $advertRepository
     * @param PaginationHelper $paginationHelper
     * @return Response
     */
    public function myAdverts(
        Request $request,
        AdvertRepository $advertRepository,
        PaginationHelper $paginationHelper
    ): Response {
        $page = $paginationHelper->getPageInput($request);
        $user = $this->getUser();
        $advertCount = count($user->getAdverts());

        $filters = new Filters();
        $statuses = [];

        if ($request->query->get('status') != null) {
            $statuses = explode(',', $request->query->get('status'));
        }

        $filters->setAdvertStatuses($statuses);

        $filteredAdverts = $advertRepository->findMyAdvertsByCategories(
            $user,
            $filters,
            $page,
            PaginationHelper::ITEMS_PER_PAGE
        );

        $paginationPages = ceil($filteredAdverts->count() / PaginationHelper::ITEMS_PER_PAGE);

        if ($paginationPages > 0 && $page > $paginationPages) {
            $this->redirect('/my-adverts');
        }

        return $this->render('advert/my_adverts.html.twig', [
            'paginationPages' => $paginationPages,
            'filteredAdverts' => $filteredAdverts->getIterator(),
            'page' => $page,
            'toggleStatus' => $this->buildStatusToggle($statuses),
            'statuses' => $statuses,
            'advertCount' => $advertCount
        ]);
    }


    /**
     * @Route("/advert/{id}/remove", name="advert_remove", requirements={"id"="\d+"})
     * @ParamConverter("advert", class="App:Advert")
     * @param Advert $advert
     * @param AdvertRemovalHandler $advertRemovalHandler
     * @return RedirectResponse
     */
    public function removeAdvert(Advert $advert, AdvertRemovalHandler $advertRemovalHandler)
    {
        $user = $this->getUser();

        if ($user instanceof User && $advert->getUser() === $user) {
            $advertRemovalHandler->handle($advert);
            $this->addFlash('success', 'Skelbimas sėkmingai pašalintas');
            return $this->redirectToRoute('my_adverts');
        } else {
            $this->addFlash('fail', 'Skelbimo pašalinti nepavyko');
            return $this->redirectToRoute('my_adverts');
        }
    }

    /**
     * @param array $selectedStatuses
     * @return array
     */
    private function buildStatusToggle(array $selectedStatuses): array
    {
        $status = [
            AdvertRepository::ADVERT_STATE_CURRENT,
            AdvertRepository::ADVERT_STATE_WITHOUT_FEEDBACK,
            AdvertRepository::ADVERT_STATE_HAS_FEEDBACK
        ];

        $statusToggle = [];
        foreach ($status as $state) {
            if (in_array($state, $selectedStatuses)) {
                $statusToggle[$state] = strtr(implode(',', $selectedStatuses), [$state => '']);
            } else {
                $statusToggle[$state] = implode(',', $selectedStatuses) . ',' . $state;
            }

            $statusToggle[$state] = trim($statusToggle[$state], ', ');
            $statusToggle[$state] = strtr($statusToggle[$state], [",," => ',']);
        }
        return $statusToggle;
    }


    /**
     * @param User|null $user
     * @param Advert $advert
     * @return bool
     */
    private function offerFormIsAvailable(?User $user, Advert $advert): bool
    {
        if ($advert->getUser() === $user) {
            return false;
        }

        foreach ($advert->getOffers() as $offer) {
            if ($offer->getUser() === $user) {
                return false;
            }
        }

        return true;
    }
}
