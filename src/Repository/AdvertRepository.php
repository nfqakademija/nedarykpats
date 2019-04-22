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

    public function findByCategories(Filters $filters, int $page, int $itemsPerPage)
    {
        $query = $this->createQueryBuilder('a')
            ->addSelect('a');
        if ($filters->getKeywords()) {
            $query
                ->innerJoin('a.categories', 'c')
                ->where($query->expr()->in('c.slug', $filters->getKeywords()));
        }

        $paginator = $this->paginate($query->getQuery(), $page, $itemsPerPage);

        return $paginator;
    }


    /**
     * @param \Doctrine\ORM\Query $dql DQL Query Object
     * @param integer $page Current page (defaults to 1)
     * @param integer $limit The total number per page (defaults to 5)
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function paginate($dql, $page = 1, $limit = 6)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))// Offset
            ->setMaxResults($limit);

        return $paginator;
    }
}
