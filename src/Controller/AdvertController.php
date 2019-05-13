<?php

namespace App\Controller;

use App\Form\OfferType;
use App\Handler\AdvertCreationHandler;
use App\Entity\Advert;
use App\Form\AdvertType;
use App\Handler\OfferCreationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AdvertController extends AbstractController
{

    /**
     * @Route ("/advert" , name="new_advert")
     * @param Request $request
     * @param AdvertCreationHandler $advertCreationHandler
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
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

            return $this->redirect('/advert/'. $advert->getid());
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
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function advert(Advert $advert, Request $request, OfferCreationHandler $offerCreationHandler)
    {
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
            'offerForm' => $offerForm->createView(),
        ]);
    }
}
