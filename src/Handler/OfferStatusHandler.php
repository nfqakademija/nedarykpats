<?php


namespace App\Handler;

use App\Entity\Advert;
use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;

class OfferStatusHandler
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * OfferStatusHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(Advert $advert, Offer $offer = null)
    {
        $advert->setAcceptedOffer($offer);
        $this->entityManager->flush();
    }
}
