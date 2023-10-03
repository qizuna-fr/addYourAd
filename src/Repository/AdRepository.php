<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ad>
 *
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    /**
     * @return Ad[] Returns an array of Ad objects
     */
    public function findAdsEndedBeforeToday(): array
    {
        $now = date('Y-m-d');
        return $this->createQueryBuilder('a')
            ->andWhere('a.endedAt < :today')
            ->setParameter('today', $now)
            ->orderBy('a.totalViews / a.weight', 'ASC')
            // to retrive the one that have the less view compared to their weight
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Ad[] Returns an array of Ad objects
     */
    public function findAdsValideToday(): array
    {
        $now = date('Y-m-d');
        return $this->createQueryBuilder('a')
            ->andWhere('a.endedAt > :today')
            ->andWhere('a.startedAt < :today')
            ->setParameter('today', $now)
            ->orderBy('a.totalViews / a.weight', 'ASC')
            // to retrive the one that have the less view compared to their weight
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Ad[] Returns an array of Ad objects
     */
    public function findAdsStartedAfterToday(): array
    {
        $now = date('Y-m-d');
        return $this->createQueryBuilder('a')
            ->andWhere('a.startedAt > :today')
            ->setParameter('today', $now)
            ->orderBy('a.totalViews / a.weight', 'ASC')
            // to retrive the one that have the less view compared to their weight
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param int $value
     * @return Ad[]
     */
    public function findANumberOfAdsValideToday(int $value): array
    {
        $now = date('Y-m-d');
        return $this->createQueryBuilder('a')
            ->andWhere('a.endedAt > :today')
            ->andWhere('a.startedAt < :today')
            ->setParameter('today', $now)
            ->orderBy('a.totalViews / a.weight', 'ASC')
            // to retrive the one that have the less view compared to their weight
            ->setMaxResults($value)
            ->getQuery()
            ->getResult()
        ;
    }
}
