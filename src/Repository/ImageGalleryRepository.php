<?php

namespace App\Repository;

use App\Entity\ImageGallery;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ImageGallery|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageGallery|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageGallery[]    findAll()
 * @method ImageGallery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageGalleryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ImageGallery::class);
    }

    public function findByUser(User $user)
    {
        $query = $this->createQueryBuilder('image_gallery');
        $query->select('image_gallery')
            ->where('image_gallery.user = :user')
            ->setParameter('user', $user);

        return $query->getQuery()->getResult();
    }

    public function findByUserHashOrAdvertID(?string $userIdentification, ?int $advertId)
    {
        $query = $this->createQueryBuilder('image_gallery');
        $query->select('image_gallery')
            ->leftJoin('image_gallery.user', 'user')
            ->leftJoin('image_gallery.advert', 'advert')
            ->where('user.identification = :userIdentification AND advert.id IS NULL')
            ->orWhere('advert.id = :advertId AND user.id IS NULL')
            ->setParameter(':userIdentification', $userIdentification)
            ->setParameter(':advertId', $advertId);

        return $query->getQuery()->getResult();
    }
}
