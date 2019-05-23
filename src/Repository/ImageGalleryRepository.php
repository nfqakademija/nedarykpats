<?php

namespace App\Repository;

use App\Entity\ImageGallery;
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
}
