<?php

namespace App\Controller;

use App\Constant\Pagination;
use App\Entity\Offer;
use App\Handler\OfferStatusHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    /**
     * @Route("/confirm-offer/{id}", name="confirm_offer", requirements={"id"="\d+"})
     * @ParamConverter("offer", class="App:Offer")
     * @param Offer $offer
     * @param OfferStatusHandler $offerStatusHandler
     * @return RedirectResponse
     */
    public function confirmOffer(Offer $offer, OfferStatusHandler $offerStatusHandler)
    {
        $advert = $offer->getAdvert();

        if ($advert->getUser() === $this->getUser()) {
            if ($advert->getAcceptedOffer()) {
                $this->addFlash('fail', 'Skelbimas jau turi patvirtintą pasiūlymą');
            } else {
                $offerStatusHandler->handleAccept($advert, $offer);
                $this->addFlash('success', 'Sveikiname pasirinkus pateiktą pasiūlymą');
            }
        } else {
            $this->addFlash('fail', 'Patvirtinimą gali atlikti tik skelbimo sąvininkas');
        }

        return $this->redirectToRoute('advert', ['id' => $advert->getId()]);
    }

    /**
     * @Route("/decline-offer/{id}", name="decline_offer", requirements={"id"="\d+"})
     * @ParamConverter("offer", class="App:Offer")
     * @param Offer $offer
     * @param OfferStatusHandler $offerStatusHandler
     * @return RedirectResponse
     */
    public function declineOffer(Offer $offer, OfferStatusHandler $offerStatusHandler)
    {
        $advert = $offer->getAdvert();

        if ($advert->getUser() === $this->getUser()) {
            if ($advert->getAcceptedOffer() && !$advert->getFeedback()) {
                $offerStatusHandler->handleDecline($advert, $offer);
                $this->addFlash('success', 'Pasiūlymas atšauktas');
            } else {
                $this->addFlash('fail', 'Skelbimas neturi patvirtinto pasiūlymo');
            }
        } elseif ($offer->getUser() === $this->getUser()) {
            if (!$advert->getFeedback()) {
                $offerStatusHandler->handleRetract($advert, $offer);
                $this->addFlash('success', 'Jūsų pasiūlymas atšauktas');
            } else {
                $this->addFlash('fail', 'Skelbimas neturi patvirtinto pasiūlymo');
            }
        } else {
            $this->addFlash('fail', 'Atmetimą gali atlikti tik skelbimo arba pasiūlymo sąvininkas');
        }

        return $this->redirectToRoute('advert', ['id' => $advert->getId()]);
    }

    /**
     * @Route("/my-offers/", name="my_offers")
     * @return Response
     */
    public function myOffer(Request $request)
    {
        $page = $this->getPageInput($request);
        $offersRepository = $this->getDoctrine()->getRepository(Offer::class);

        $offers = $offersRepository->findByUser($this->getUser(), $page, Pagination::ITEMS_PER_PAGE);

        $paginationPages = ceil($offers->count() / Pagination::ITEMS_PER_PAGE);

        if ($paginationPages > 0 && $page > $paginationPages) {
            $page = $paginationPages;
            $offers = $offersRepository->findByUser($this->getUser(), $page, Pagination::ITEMS_PER_PAGE);
        }

        return $this->render('offer/my_offers.html.twig', [
            'offers' => $offers,
            'page' => $page,
            'paginationPages' => $paginationPages,
        ]);
    }

    /**
     * @param Request $request
     * @return int
     */
    private function getPageInput(Request $request)
    {
        $pageInput = $request->query->get('page') ? $request->query->get('page') : 1;
        $pageCastToInt =  ctype_digit($pageInput)  ? $pageInput : 1;
        $page = $pageCastToInt > 0 ? $pageCastToInt : 1;

        return $page;
    }
}
