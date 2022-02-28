<?php

namespace App\Repository;

use App\Entity\SnowFigure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SnowFigure|null find($id, $lockMode = null, $lockVersion = null)
 * @method SnowFigure|null findOneBy(array $criteria, array $orderBy = null)
 * @method SnowFigure[]    findAll()
 * @method SnowFigure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SnowFigureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SnowFigure::class);
    }

    // /**
    //  * @return SnowFigure[] Returns an array of SnowFigure objects
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
    public function findOneBySomeField($value): ?SnowFigure
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
