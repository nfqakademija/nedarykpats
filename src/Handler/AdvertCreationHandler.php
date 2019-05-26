<?php
namespace App\Handler;

use App\DTO\AdvertFormDTO;
use App\DTO\ImageGalleryFormDTO;
use App\Entity\Advert;
use App\Entity\User;
use App\Service\TokenGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AdvertCreationHandler
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
     * @var ImageUploadHandler
     */
    private $imageUploadHandler;

    /**
     * AdvertCreationHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface $tokenStorage
     * @param UserCreationHandler $userCreationHandler
     * @param EmailHandler $emailHandler
     * @param TokenGeneratorService $tokenGeneratorService
     * @param ImageUploadHandler $imageUploadHandler
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        UserCreationHandler $userCreationHandler,
        EmailHandler $emailHandler,
        TokenGeneratorService $tokenGeneratorService,
        ImageUploadHandler $imageUploadHandler
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->userCreationHandler = $userCreationHandler;
        $this->emailHandler = $emailHandler;
        $this->tokenGeneratorService = $tokenGeneratorService;
        $this->imageUploadHandler = $imageUploadHandler;
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
            ->setCity($advertFormDTO->getCity())
            ->setUser($user)
            ->setIsConfirmed($advertConfirmed);

        $this->entityManager->persist($advert);
        $this->entityManager->flush();

        /** @var UploadedFile $item */
        foreach ($advertFormDTO->getImageGallery() as $item) {
            $imageGalleryFormDTO = new ImageGalleryFormDTO();
            $imageGalleryFormDTO->setImageFile($item);
            $this->imageUploadHandler->handle($imageGalleryFormDTO, null, $advert);
        }

        if (!$advertConfirmed) {
            $hash = $this->tokenGeneratorService->generate(
                $user,
                $advert,
                null
            );
            $this->emailHandler->sendAdvertConfirmationWithSingleLoginUrl($advertFormDTO->getEmail(), $hash->getHash());
        }

        return $advert;
    }
}
