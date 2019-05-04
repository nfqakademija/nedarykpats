<?php
namespace App\Service;

use App\Entity\Advert;
use App\Entity\Offer;
use App\Entity\Token;
use App\Entity\User;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;

class TokenConsumerService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TokenRepository
     */
    private $tokenRepository;


    /**
     * TokenConsumerService constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenRepository $tokenRepository
     */
    public function __construct(EntityManagerInterface $entityManager, TokenRepository $tokenRepository)
    {
        $this->entityManager = $entityManager;
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @param Token $token
     * @return array
     */
    public function consume(Token $token): array
    {
        $entity = $this->tokenRepository->findOneBy(['hash' => $token->getHash()]);

        if ($entity->getUser()) {
            $this->confirmUser($entity);
            $this->expireToken($token);
            return ['EntityConfirmed' => 'User'];
        } elseif ($entity->getAdvert()) {
            $this->confirmAdvert($entity);
            $this->expireToken($token);
            return ['EntityConfirmed' => 'Advert', 'id' => $entity->getAdvert()->getId()];
        } elseif ($entity->getOffer()) {
            $this->confirmOffer($entity);
            $this->expireToken($token);
            $advertId = $entity->getOffer()->getAdvert()->getId();
            return ['EntityConfirmed' => 'Offer', 'advertId' => $advertId];
        }
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
            $this->expireToken($token);
            return true;
        }

        return false;
    }


    /**
     * @param $entity
     */
    private function confirmUser($entity): void
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $entity->getUser()->getEmail()]);

        $user->setIsConfirmed(true);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param $entity
     */
    private function confirmAdvert($entity): void
    {
        $advertRepository = $this->entityManager->getRepository(Advert::class);
        $advert = $advertRepository->findOneBy(['email' => $entity->getUser()->getEmail()]);

        $advert->setIsConfirmed(true);
        $this->entityManager->persist($advert);
        $this->entityManager->flush();
    }


    /**
     * @param $entity
     */
    private function confirmOffer($entity): void
    {
        $offerRepository = $this->entityManager->getRepository(Offer::class);
        $offer = $offerRepository->findOneBy(['email' => $entity->getUser()->getEmail()]);

        $offer->setIsConfirmed(true);
        $this->entityManager->persist($offer);
        $this->entityManager->flush();
    }


    /**
     * @param Token $token
     */
    private function expireToken(Token $token): void
    {
        $tokenRepository = $this->entityManager->getRepository(Token::class);
        $token = $tokenRepository->findOneBy(['hash' => $token->getHash()]);

        $token->setExpired(true);
        $this->entityManager->persist($token);
        $this->entityManager->flush();
    }
}
