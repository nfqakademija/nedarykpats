<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $email
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findUserByEmail(string $email)
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.email = :email')
            ->setParameter(':email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $email
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRecentOffersAndAdvertsCount(string $email)
    {
        $query = $this->createQueryBuilder('user');
        $adverts = $query->select('COUNT(adverts.id)')
            ->innerJoin('user.adverts', 'adverts')
            ->where('user.email = :email')
            ->andWhere('adverts.createdAt > :date')
            ->setParameter('email', $email)
            ->setParameter('date', new \DateTime('-2 minute'))
            ->getQuery()
            ->getSingleScalarResult();

        $query = $this->createQueryBuilder('user');
        $offers = $query->select('COUNT(offers.id)')
            ->innerJoin('user.offers', 'offers')
            ->where('user.email = :email')
            ->andWhere('offers.createdAt > :date')
            ->setParameter('email', $email)
            ->setParameter('date', new \DateTime('-2 minute'))
            ->getQuery()
            ->getSingleScalarResult();

        return $adverts + $offers;
    }
}
