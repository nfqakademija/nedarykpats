<?php

namespace App\Repository;

use App\Entity\Feedback;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Feedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feedback[]    findAll()
 * @method Feedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackRepository extends ServiceEntityRepository
{
    const MAX_FEEDBACK_RESULTS = 6;

    /**
     * FeedbackRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Feedback::class);
    }

    public function findByUser(User $user)
    {
        $query = $this->createQueryBuilder('feedback');

        $query->select('feedback, CASE WHEN feedback.message IS NOT NULL THEN 1 ELSE 0 END AS HIDDEN Flag')
            ->where('feedback.receivingUser = :user')
            ->setParameter(':user', $user)
            ->orderBy('Flag', 'DESC')
            ->addOrderBy('feedback.id', 'DESC')
            ->setMaxResults(self::MAX_FEEDBACK_RESULTS);

        return $query->getQuery()->getResult();
    }
}
