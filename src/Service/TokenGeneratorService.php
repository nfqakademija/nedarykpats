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
     * @param string $email
     * @param \DateTime $createDate
     * @param User $user
     * @param Advert|null $advert
     * @param Offer|null $offer
     * @return Token
     */
    public function generate(string $email, \DateTime $createDate, User $user, ?Advert $advert, ?Offer $offer ) : Token
    {
        $token = new Token();
        $token
            ->setHash($this->generateHash($email))
            ->setCreatedAt($createDate)
            ->setExpiresAt($createDate->modify('+ 2 hours'))
            ->setExpired(false)
            ->setUser($user);

        $advert ? $token->setAdvert($advert) : null;
        $offer ? $token->setOffer($offer) : null;

        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return $token;
    }

    /**
     * @param string $email
     * @return string
     */
    private function generateHash(string $email) :string
    {
        $random_prefix = rand();
        $random_suffix = rand();
        $hash = md5($random_prefix.$email.$random_suffix);

        return $hash;
    }
}
