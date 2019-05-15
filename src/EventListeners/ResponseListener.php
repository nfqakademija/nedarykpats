<?php


namespace App\EventListeners;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ResponseListener
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * ResponseListener constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface $token
     */
    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $token)
    {
        $this->entityManager = $entityManager;
        $this->token = $token;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        /** @var User $user */
        $user = $this->token->getToken()->getUser();

        $advert = $user->getAdverts();
        $advertForFeedback = [];

        foreach ($advert as $item) {
            if ($item->getAcceptedOffer()) {
                if (!$item->getFeedback()) {
                    array_push($advertForFeedback, [$item->getId() => $item->getAcceptedOffer()->getUser()->getId()]);
                }
            }
        }
        if (count($advertForFeedback) > 0) {
            ksort($advertForFeedback);
            $response = $event->getResponse();
            $response->headers->add(['Display', $advertForFeedback[0]]);
        }
    }
}
