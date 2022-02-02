<?php

namespace App\Repository;

use App\Entity\SnowCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SnowCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SnowCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SnowCategory[]    findAll()
 * @method SnowCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SnowCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SnowCategory::class);
    }

    // /**
    //  * @return SnowCategory[] Returns an array of SnowCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SnowCategory
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
