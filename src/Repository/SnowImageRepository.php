<?php

namespace App\Repository;

use App\Entity\SnowImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SnowImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SnowImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SnowImage[]    findAll()
 * @method SnowImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SnowImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SnowImage::class);
    }

    // /**
    //  * @return SnowImage[] Returns an array of SnowImage objects
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
    public function findOneBySomeField($value): ?SnowImage
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
