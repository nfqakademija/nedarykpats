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
     * @param ImageUploadHandler $imageUploadHandler
     * @param UserUpdateHandler $userUpdateHandler
     * @param UserRetrieveHandler $userRetrieveHandler
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        UserCreationHandler $userCreationHandler,
        EmailHandler $emailHandler,
        TokenGeneratorService $tokenGeneratorService,
        ImageUploadHandler $imageUploadHandler,
        UserUpdateHandler $userUpdateHandler,
        UserRetrieveHandler $userRetrieveHandler
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->userCreationHandler = $userCreationHandler;
        $this->emailHandler = $emailHandler;
        $this->tokenGeneratorService = $tokenGeneratorService;
        $this->imageUploadHandler = $imageUploadHandler;
        $this->userUpdateHandler = $userUpdateHandler;
        $this->userRetrieveHandler = $userRetrieveHandler;
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
            $user = $this->userRetrieveHandler->getUser($advertFormDTO->getEmail());
            $advertConfirmed = false;
        }
        if (!$user instanceof User) {
            $user = $this->userCreationHandler->createUser($advertFormDTO->getEmail(), $advertFormDTO->getName());
        } elseif ($user->getName() !== $advertFormDTO->getName()) {
            $user = $this->userUpdateHandler->handle(
                $user,
                $advertFormDTO->getName()
            );
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

        $imageGalleryFormDTO = new ImageGalleryFormDTO();
        $imageGalleryFormDTO->setImageFile($advertFormDTO->getImageGallery());
        $this->imageUploadHandler->handle($imageGalleryFormDTO, null, $advert);


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
