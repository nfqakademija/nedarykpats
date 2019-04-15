<?php

namespace App\Repository;

use App\Entity\Advert;
use App\SearchObjects\Filters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Advert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advert[]    findAll()
 * @method Advert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Advert::class);
    }
    public function findByCategories(Filters $filters) {
         $query = $this->createQueryBuilder('a')
            ->select('a');
         if($filters->getKeywords()) {
             $query
                 ->innerJoin('a.categories', 'c')
                 ->where($query->expr()->in('c.slug', $filters->getKeywords()));
         }
         return $query
             ->getQuery()
             ->getResult();
    }
}
