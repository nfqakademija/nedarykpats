<?php


namespace App\Handler;

use App\DTO\FeedbackFormDTO;
use App\Entity\Advert;
use App\Entity\Feedback;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class FeedbackCreationHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * FeedbackCreationHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param FeedbackFormDTO $feedbackFormDTO
     * @return bool
     * @throws \Exception
     */
    public function handle(FeedbackFormDTO $feedbackFormDTO) : bool
    {
        $advert = $this->entityManager->getRepository(Advert::class)->find($feedbackFormDTO->getAdvert());
        $receivingUser = $this->entityManager->getRepository(User::class)->find($feedbackFormDTO->getReceivingUser());

        //TODO: kol nėra tvarkingų fikstūrų - pridėta, kad acceptedOffer === null.
        //TODO: kodel lyginamas prisijunges asmuo su offerio user id?
//        if ($advert->getAcceptedOffer() === null || $advert->getAcceptedOffer()->getUser() == $receivingUser) {
            $feedback = (new Feedback())
                ->setAdvert($advert)
                ->setReceivingUser($receivingUser)
                ->setScore($feedbackFormDTO->getScore())
                ->setMessage($feedbackFormDTO->getMessage())
                ->setCreatedAt(new \DateTime('now'));

            $this->entityManager->persist($feedback);
            $this->entityManager->flush();
            return true;
//        }

        return false;
    }
}
