<?php

namespace App\Repository;

use App\Entity\SnowVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SnowVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method SnowVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method SnowVideo[]    findAll()
 * @method SnowVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SnowVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SnowVideo::class);
    }

    // /**
    //  * @return SnowVideo[] Returns an array of SnowVideo objects
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
    public function findOneBySomeField($value): ?SnowVideo
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
