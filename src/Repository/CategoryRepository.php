<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findAvailableCategoriesForFilter()
    {
        return $this->createQueryBuilder('category')
            ->select('category')
            ->innerJoin('category.adverts', 'adverts')
            ->getQuery()
            ->getResult();
    }

    public function findUsersTopCategoryTitles(User $user)
    {
        $entityManager = $this->getEntityManager();

        return $query = $entityManager->createQuery(
            'SELECT c.id, c.title, COUNT(1) AS Count
            FROM App\Entity\Category c
            JOIN c.adverts a
            JOIN a.offers o
            JOIN o.user u
            WHERE u.id = ?1
            GROUP BY c.id
            ORDER BY Count DESC'
        )->setParameter(1, $user->getId())
            ->setMaxResults("3")
            ->getResult();
    }
}
