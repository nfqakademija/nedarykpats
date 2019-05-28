<?php

namespace App\Controller;

use App\Constant\Pagination;
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
        OfferCreationHandler $offerCreationHandler
    ) {
        $offerForm = $this->createForm(OfferType::class);

        $offerForm->handleRequest($request);

        if ($offerForm->isSubmitted() && $offerForm->isValid()) {
            $offerFormDTO = $offerForm->getData();
            $offerFormDTO->setAdvert($advert);
            $offer = $offerCreationHandler->handle($offerFormDTO);
            $email = $offerFormDTO->getEmail();

            if ($offer->isConfirmed()) {
                $this->addFlash('success', 'Pateikta užklausa sėkmingai išsaugota');
            } else {
                $this->addFlash('success', 'Jums išsiųstas patvirtinimo laiškas šiuo el. paštu ' . $email);
            }

            return $this->redirect($request->getUri());
        }

        return $this->render('advert/single_advert.html.twig', [
            'advert' => $advert,
            'offerForm' => $offerForm->createView()
        ]);
    }

    /**
     * @Route("/my-adverts", name="my_adverts")
     * @param Request $request
     * @param AdvertRepository $advertRepository
     * @return Response
     */
    public function myAdverts(
        Request $request,
        AdvertRepository $advertRepository
    ): Response {
        $page = $this->getPageInput($request);
        $user = $this->getUser();

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
            Pagination::ITEMS_PER_PAGE
        );

        $paginationPages = ceil($filteredAdverts->count() / Pagination::ITEMS_PER_PAGE);

        if ($paginationPages > 0 && $page > $paginationPages) {
            $page = $paginationPages;
            $filteredAdverts = $advertRepository
                ->findMyAdvertsByCategories($user, $filters, $page, Pagination::ITEMS_PER_PAGE);
        }

        return $this->render('advert/my_adverts.html.twig', [
            'paginationPages' => $paginationPages,
            'filteredAdverts' => $filteredAdverts->getIterator(),
            'page' => $page,
            'toggleStatus' => $this->buildStatusToggle($statuses),
            'status' => $statuses
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
     * @param Request $request
     * @return int
     */
    private function getPageInput(Request $request)
    {
        $pageInput = $request->query->get('page') ? $request->query->get('page') : 1;
        $pageCastToInt = ctype_digit($pageInput) ? $pageInput : 1;
        $page = $pageCastToInt > 0 ? $pageCastToInt : 1;

        return $page;
    }
}
