<?php


namespace App\Handler;

use App\DTO\OfferFormDTO;
use App\Entity\Advert;
use App\Entity\Offer;
use App\Entity\User;
use App\Service\TokenGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OfferCreationHandler
{

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var UserCreationHandler
     */
    private $userCreationHandler;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EmailHandler
     */
    private $emailHandler;

    /**
     * @var TokenGeneratorService
     */
    private $tokenGeneratorService;

    /**
     * AdvertCreationHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface $tokenStorage
     * @param UserCreationHandler $userCreationHandler
     * @param EmailHandler $emailHandler
     * @param TokenGeneratorService $tokenGeneratorService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        UserCreationHandler $userCreationHandler,
        EmailHandler $emailHandler,
        TokenGeneratorService $tokenGeneratorService
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->userCreationHandler = $userCreationHandler;
        $this->emailHandler = $emailHandler;
        $this->tokenGeneratorService = $tokenGeneratorService;
    }

    /**
     * @param OfferFormDTO $offerFormDTO
     * @param Advert $advert
     * @return Offer
     * @throws \Exception
     */
    public function handle(OfferFormDTO $offerFormDTO)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $offerConfirmed = true;


        if (!$user instanceof User) {
            $user = $this->userCreationHandler->getUser($offerFormDTO->getEmail());
            $offerConfirmed = false;
        }
        if (!$user instanceof User) {
            $user = $this->userCreationHandler->createUser($offerFormDTO->getEmail());
        }

        $offer = new Offer();

        $offer->setAdvert($offerFormDTO->getAdvert())
            ->setText($offerFormDTO->getText())
            ->setUser($user)
            ->setIsConfirmed($offerConfirmed);

        $this->entityManager->persist($offer);
        $this->entityManager->flush();

        if (!$offerConfirmed) {
            $hash = $this->tokenGeneratorService->generate(
                $user,
                null,
                $offer
            );
            $this->emailHandler->sendOfferConfirmationWithSingleLoginUrl($offerFormDTO->getEmail(), $hash->getHash());
        }

        return $offer;
    }
}
