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
     * @var UserUpdateHandler
     */
    private $userUpdateHandler;

    /**
     * @var UserRetrieveHandler
     */
    private $userRetrieveHandler;

    /**
     * AdvertCreationHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface $tokenStorage
     * @param UserCreationHandler $userCreationHandler
     * @param EmailHandler $emailHandler
     * @param TokenGeneratorService $tokenGeneratorService
     * @param UserUpdateHandler $userUpdateHandler
     * @param UserRetrieveHandler $userRetrieveHandler
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        UserCreationHandler $userCreationHandler,
        EmailHandler $emailHandler,
        TokenGeneratorService $tokenGeneratorService,
        UserUpdateHandler $userUpdateHandler,
        UserRetrieveHandler $userRetrieveHandler
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->userCreationHandler = $userCreationHandler;
        $this->emailHandler = $emailHandler;
        $this->tokenGeneratorService = $tokenGeneratorService;
        $this->userUpdateHandler = $userUpdateHandler;
        $this->userRetrieveHandler = $userRetrieveHandler;
    }

    /**
     * @param OfferFormDTO $offerFormDTO
     * @return Offer
     * @throws \Exception
     */
    public function handle(OfferFormDTO $offerFormDTO)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $offerConfirmed = true;

        if (!$user instanceof User) {
            $user = $this->userRetrieveHandler->getUser($offerFormDTO->getEmail());
            $offerConfirmed = false;
        }
        if (!$user instanceof User) {
            $user = $this->userCreationHandler->createUser(
                $offerFormDTO->getEmail(),
                $offerFormDTO->getName()
            );
        }

        if ($offerFormDTO->getAdvert()->getUser() === $user) {
            throw new \Exception();
        }

        if ($user->getName() == null  && $offerFormDTO->getName()) {
            $user = $this->userUpdateHandler->handle(
                $user,
                $offerFormDTO->getName()
            );
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
