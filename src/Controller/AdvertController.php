<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AdvertController extends AbstractController
{
    /**
     * @Route("/advert", name="new_advert")
     */
    public function index()
    {
        return $this->render('advert/index.html.twig', [
            'controller_name' => 'AdvertController',
        ]);
    }

    /**
     * @Route("/advert/{id}", name="advert", requirements={"id"="\d+"})
     * @ParamConverter("advert", class="App:Advert")
     * @param Advert $advert
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function advert(
        Advert $advert,
        Request $request
    ) {

        $offer = new Offer($advert);

        $offerForm = $this->createFormBuilder($offer)
            ->add('email')
            ->add('text')
            ->add('save', SubmitType::class, ['label' => 'Siųsti'])
            ->getForm();

        $offerForm->handleRequest($request);

        if ($offerForm->isSubmitted() && $offerForm->isValid()) {
            $offer = $offerForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            $this->addFlash('success', 'Siūlymas išsaugotas');

            return $this->redirect($request->getUri());
        }

        return $this->render('advert/advert.html.twig', [
            'advert' => $advert,
            'offerForm' => $offerForm->createView(),
        ]);
    }
}
