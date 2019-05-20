<?php

namespace App\Repository;

use App\Entity\Advert;
use App\Entity\User;
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

    /**
     * @param Filters $filters
     * @param int $page
     * @param int $itemsPerPage
     * @return Paginator
     */
    public function findByCategories(Filters $filters, int $page, int $itemsPerPage)
    {
        $query = $this->createQueryBuilder('a')
            ->addSelect('a')
            ->where('a.isConfirmed = 1');
        if ($filters->getKeywords()) {
            $query
                ->innerJoin('a.categories', 'c')
                ->andWhere($query->expr()->in('c.slug', $filters->getKeywords()));
            ;
        }

        $query->orderBy('a.createdAt', 'DESC');

        $paginator = $this->paginate($query->getQuery(), $page, $itemsPerPage);

        return $paginator;
    }

    /**
     * @param User $user
     * @param Filters $filters
     * @param int $page
     * @param int $itemsPerPage
     * @return Paginator
     */
    public function findMyAdvertsByCategories(User $user, Filters $filters, int $page, int $itemsPerPage)
    {
        $query = $this->createQueryBuilder('a')
            ->innerJoin('a.user', 'u')
            ->where('u.id = :userId')
            ->andWhere('a.isConfirmed = 1')
            ->setParameter(':userId', $user->getId());

        if ($filters->getKeywords()) {
            $query
                ->innerJoin('a.categories', 'c')
                ->andWhere($query->expr()->in('c.slug', $filters->getKeywords()));
        }
        if ($filters->getAdvertStatus()) {
            switch ($filters->getAdvertStatus()) {
                case 1:
                    $query->andWhere('a.acceptedOffer is null');
                    break;
                case 2:
                    $query
                        ->leftJoin('a.feedback', 'f')
                        ->andWhere('a.acceptedOffer is not null')
                        ->andWhere('f.id is null');
                    break;
                case 3:
                    $query
                        ->innerJoin('a.feedback', 'f')
                        ->andWhere('a.acceptedOffer is not null');
                    break;
                default:
                    break;
            }
        }
        $query->orderBy('a.createdAt', 'DESC');

        $paginator = $this->paginate($query->getQuery(), $page, $itemsPerPage);

        return $paginator;
    }


    /**
     * @param Advert $advert
     * @return mixed
     */
    public function findAdvertOffersUsers(Advert $advert): ?array
    {
        $entityManager = $this->getEntityManager();

        return $query = $entityManager->createQuery(
            'SELECT u 
       FROM App\Entity\User u
       JOIN u.offers o
       JOIN o.advert a
       WHERE a.id = ?1'
        )->setParameter(1, $advert->getId())->getResult();
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
