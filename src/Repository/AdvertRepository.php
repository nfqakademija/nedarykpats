<?php

namespace App\Repository;

use App\Entity\Advert;
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

    // /**
    //  * @return Advert[] Returns an array of Advert objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Advert
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /**
     * @param Filter $filter
     * @return Paginator
     */
    public function findFilteredTrainers(Filter $filter): Paginator
    {
//        $qb = $this->createQueryBuilder('t');
//        if ($filter->getStartsAt() && $filter->getEndsAt()) {
//            $qb->innerJoin('t.availabilitySlots', 'a', Join::WITH, $qb->expr()->andX(
//                $qb->expr()->lte('a.startsAt', ':from'),
//                $qb->expr()->gte('a.endsAt', ':to')
//            ))
//                ->leftJoin('t.scheduledWorkouts', 's', Join::WITH, $qb->expr()->orX(
//                    $qb->expr()->andX(
//                        $qb->expr()->gte('s.startsAt', ':from'),
//                        $qb->expr()->lt('s.startsAt', ':to')
//                    ),
//                    $qb->expr()->andX(
//                        $qb->expr()->gt('s.endsAt', ':from'),
//                        $qb->expr()->lte('s.endsAt', ':to')
//                    ),
//                    $qb->expr()->andX(
//                        $qb->expr()->gte('s.startsAt', ':from'),
//                        $qb->expr()->lte('s.endsAt', ':to')
//                    ),
//                    $qb->expr()->andX(
//                        $qb->expr()->lte('s.startsAt', ':from'),
//                        $qb->expr()->gte('s.endsAt', ':to')
//                    )
//                ))->where(
//                    $qb->expr()->isNull('s.id')
//                )->setParameters(['from' => $filter->getStartsAt(), 'to' => $filter->getEndsAt()]);
//        }
//        if ($filter->getName()) {
//            $qb->andWhere('t.name LIKE :name')->setParameter('name', '%' . $filter->getName() . '%');
//        }
//
//        if (!empty($filter->getTags())) {
//            $qb->innerJoin('t.tags', 'f')
//                ->andWhere($qb->expr()->in('f.id', $filter->getTags()));
//        }
//
//        $query = $qb->getQuery();
//        $paginator = $this->paginate($query, $filter->getPage(), $filter->getItemsPerPage());
//
//        return $paginator;
    }

    /**
     * Paginator Helper
     *
     * Pass through a query object, current page & limit
     * the offset is calculated from the page and limit
     * returns an `Paginator` instance, which you can call the following on:
     *
     *     $paginator->getIterator()->count() # Total fetched (ie: `5` posts)
     *     $paginator->count() # Count of ALL posts (ie: `20` posts)
     *     $paginator->getIterator() # ArrayIterator
     *
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
