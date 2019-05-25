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

    /**
     * @param Advert $advert
     * @param Offer $offer
     * @throws \Exception
     */
    public function handleAccept(Advert $advert, Offer $offer)
    {
        $advert
            ->setAcceptedOffer($offer)
            ->setUpdatedAt(new \DateTime('now'));
        $this->entityManager->flush();
    }

    /**
     * @param Advert $advert
     * @param Offer $offer
     * @throws \Exception
     */
    public function handleDecline(Advert $advert, Offer $offer)
    {
        $advert
            ->setAcceptedOffer(null)
            ->setUpdatedAt(new \DateTime('now'));
        $offer->setIsDeclined(true);
        $this->entityManager->flush();
    }

    /**
     * @param Advert $advert
     * @param Offer $offer
     * @throws \Exception
     */
    public function handleRetract(Advert $advert, Offer $offer)
    {
        $advert
            ->setAcceptedOffer(null)
            ->setUpdatedAt(new \DateTime('now'));
        $offer->setIsRetracted(true);
        $this->entityManager->flush();
    }
}
