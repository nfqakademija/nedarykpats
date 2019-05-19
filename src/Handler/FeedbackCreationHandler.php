<?php


namespace App\Handler;

use App\DTO\FeedbackFormDTO;
use App\Entity\Advert;
use App\Entity\Feedback;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

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
     * @throws Exception
     */
    public function handle(FeedbackFormDTO $feedbackFormDTO): bool
    {
        /** @var Advert $advert */
        $advert = $this->entityManager->getRepository(Advert::class)->find($feedbackFormDTO->getAdvert());

        //Logic behind: Advert does not have accepted offer or Advert has Feedback then return false
        if ($advert->getAcceptedOffer() === null || $advert->getFeedback() instanceof Feedback) {
            return false;
        }

        $feedback = (new Feedback())
            ->setAdvert($advert)
            ->setReceivingUser($advert->getAcceptedOffer()->getUser())
            ->setScore($feedbackFormDTO->getScore())
            ->setMessage($feedbackFormDTO->getMessage())
            ->setCreatedAt(new DateTime('now'));

        $this->entityManager->persist($feedback);
        $this->entityManager->flush();
        return true;
    }
}
