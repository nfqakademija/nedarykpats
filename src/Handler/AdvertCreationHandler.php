<?php
namespace App\Handler;

use App\Entity\Advert;
use App\Service\EmailHandler;
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
     * TODO: AdvertFormDTO (first form must be checked)
     * @param Advert $advert
     * @throws \Exception
     */
    public function handle(Advert $advert)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $advertConfirmed = true;

        if (!$user) {
            $user = $this->userCreationHandler->createUser('test@test.lt');
            $advertConfirmed = false;
        }

        //TODO: When AdvertFormDTO used advert must be created here. Now email is only set here.
        $advert->setUser($user);
        $advert->setIsConfirmed($advertConfirmed);

        $this->entityManager->persist($advert);
        $this->entityManager->flush();

        if (!$advertConfirmed) {
            $hash = $this->tokenGeneratorService->generate('email', new \DateTime('now'), $user, $advert, null);
            $this->emailHandler->sendAdvertConfirmationWithSingleLoginUrl('email', $hash->getHash());
        }
    }
}
