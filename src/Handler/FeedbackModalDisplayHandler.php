<?php

namespace App\Handler;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FeedbackModalDisplayHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * FeedbackCreationHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function handleDataCheck()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $date = new \DateTime('now');
        $interval = new \DateInterval('PT15S');

        if ($user instanceof User) {
            $advert = $user->getAdverts();

            foreach ($advert as $item) {
                if ($item->getAcceptedOffer()) {
                    if (!$item->getFeedback() && date_add($item->getUpdatedAt(), $interval) < $date) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public function handleDataCollection()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $advertForFeedback = [];

        if ($user instanceof User) {
            $advert = $user->getAdverts();

            foreach ($advert as $item) {
                if ($item->getAcceptedOffer()) {
                    if (!$item->getFeedback()) {
                        array_push(
                            $advertForFeedback,
                            [$item->getId(), $item->getAcceptedOffer()->getUser()->getName()]
                        );
                    }
                }
            }
            ksort($advertForFeedback);
            return $advertForFeedback[0];
        }
        return $advertForFeedback;
    }
}
