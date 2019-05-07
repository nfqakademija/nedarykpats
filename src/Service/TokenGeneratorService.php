<?php

namespace App\Service;

use App\Entity\Offer;
use App\Entity\Token;
use App\Entity\Advert;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class TokenGeneratorService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * RegistrationHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param User $user
     * @param Advert|null $advert
     * @param Offer|null $offer
     * @return Token
     * @throws \Exception
     */
    public function generate(User $user, ?Advert $advert, ?Offer $offer): Token
    {
        $token = new Token();
        $createDate = new \DateTime('now');
        $token
            ->setHash(md5(microtime()))
            ->setCreatedAt($createDate)
            ->setExpiresAt($createDate->modify('+ 2 hours'))
            ->setExpired(false)
            ->setUser($user);

        if ($advert) {
            $token->setAdvert($advert);
        }

        if ($offer) {
            $token->setOffer($offer);
        }

        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return $token;
    }
}
