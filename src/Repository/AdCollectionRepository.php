<?php

namespace App\Repository;

use App\Entity\AdCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdCollection>
 *
 * @method AdCollection|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdCollection[]    findAll()
 * @method AdCollection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdCollection::class);
    }

//    /**
//     * @return AdCollection[] Returns an array of AdCollection objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AdCollection
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
