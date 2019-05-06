<?php
namespace App\Handler;

use App\DTO\AdvertFormDTO;
use App\Entity\Advert;
use App\Entity\User;
use App\Service\TokenGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AdvertCreationHandler
{

    private $tokenStorage;

    private $userCreationHandler;

    private $entityManager;

    private $emailHandler;

    private $tokenGeneratorService;

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
     * @param AdvertFormDTO $advertFormDTO
     * @return Advert
     * @throws \Exception
     */
    public function handle(AdvertFormDTO $advertFormDTO)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $advertConfirmed = true;


        if (!$user instanceof User) {
            $user = $this->userCreationHandler->getUser($advertFormDTO->getEmail());
            $advertConfirmed = false;
        }
        if (!$user instanceof User) {
            $user = $this->userCreationHandler->createUser($advertFormDTO->getEmail());
        }

        $advert = new Advert();
        $advert->setTitle($advertFormDTO->getTitle())
            ->setText($advertFormDTO->getText())
            ->setCategories($advertFormDTO->getCategories())
            ->setUser($user)
            ->setIsConfirmed($advertConfirmed);

        $this->entityManager->persist($advert);
        $this->entityManager->flush();

        if (!$advertConfirmed) {
            $hash = $this->tokenGeneratorService->generate(
                $advertFormDTO->getEmail(),
                new \DateTime('now'),
                $user,
                $advert,
                null
            );
            $this->emailHandler->sendAdvertConfirmationWithSingleLoginUrl($advertFormDTO->getEmail(), $hash->getHash());
        }

        return $advert;
    }
}
