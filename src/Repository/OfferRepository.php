<?php

namespace App\Repository;

use App\Entity\Advert;
use App\Entity\Offer;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository
{
    /**
     * OfferRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    /**
     * @param User $user
     * @param int $page
     * @param int $itemsPerPage
     * @return Paginator
     */
    public function findByUser(User $user, int $page, int $itemsPerPage)
    {
        $query = $this->createQueryBuilder('offer');

        $query->addSelect(
            'CASE
                WHEN advert.acceptedOffer = offer AND feedback.id IS NOT NULL THEN 5
                WHEN advert.acceptedOffer = offer THEN 4
                WHEN advert.acceptedOffer <> offer THEN 2
                WHEN offer.isRetracted = 1 THEN 1
                WHEN offer.isDeclined = 1 THEN 0
                ELSE 3
                END AS HIDDEN SortOrder'
        )
            ->innerJoin('offer.advert', 'advert')
            ->leftJoin('advert.feedback', 'feedback')
            ->where('offer.user = :user')
            ->andWhere('advert.isDeleted = 0')
            ->setParameter('user', $user)
            ->orderBy('SortOrder', 'DESC')
            ->addOrderBy('offer.id', 'DESC');

        $paginator = $this->paginate($query->getQuery(), $page, $itemsPerPage);
        return $paginator;
    }

    /**
     * @param Query $dql DQL Query Object
     * @param integer $page Current page (defaults to 1)
     * @param integer $limit The total number per page (defaults to 5)
     * @return Paginator
     */
    public function paginate($dql, $page = 1, $limit = 6)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))// Offset
            ->setMaxResults($limit);

        return $paginator;
    }

    /**
     * @param Advert $advert
     * @return mixed
     */
    public function findByAdvert(Advert $advert)
    {
        $query = $this->createQueryBuilder('offer');

        $query->select(
            'offer,
             CASE WHEN advert.acceptedOffer IS NOT NULL AND advert.acceptedOffer = offer.id 
                THEN 1 
                ELSE 0 
            END AS HIDDEN Flag'
        )
            ->join('offer.advert', 'advert')
            ->where('offer.advert = :advert')
            ->andWhere('offer.isConfirmed = 1')
            ->setParameter('advert', $advert)
            ->orderBy('Flag', 'DESC')
            ->addOrderBy('offer.id', 'DESC');

        return $query->getQuery()->getResult();
    }
}
