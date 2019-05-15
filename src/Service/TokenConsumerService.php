<?php

namespace App\Service;

use App\Entity\Token;
use Doctrine\ORM\EntityManagerInterface;

class TokenConsumerService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * TokenConsumerService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Token $token
     * @return void
     */
    public function consume(Token $token): void
    {
        $token->getUser()->setIsConfirmed(true);

        if ($token->getAdvert()) {
            $token->getAdvert()->setIsConfirmed(true);
        } elseif ($token->getOffer()) {
            $token->getOffer()->setIsConfirmed(true);
        }

        $token->setExpired(true);

        $this->entityManager->flush();
    }


    /**
     * @param Token $token
     * @return bool
     * @throws \Exception
     */
    public function checkIfExpired(Token $token): bool
    {
        if ($token->getExpired()) {
            return true;
        }

        $now = new \DateTime('now');

        if ($now > $token->getExpiresAt()) {
            return true;
        }

        return false;
    }
}
