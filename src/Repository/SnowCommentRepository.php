<?php

namespace App\Repository;

use App\Entity\SnowComment;
use App\Entity\SnowFigure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SnowComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method SnowComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method SnowComment[]    findAll()
 * @method SnowComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SnowCommentRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 5;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SnowComment::class);
    }

    /**
     * Method getCommentPaginator.
     *
     * @param SnowFigure $snowFigure Snowfigure Entity Reference
     * @param int        $offset     Get offset value
     */
    public function getCommentPaginator(SnowFigure $snowFigure, int $offset): Paginator
    {
        $query = $this->createQueryBuilder('s')
            ->andWhere('s.snowFigure = :snowFigure')
            ->setParameter('snowFigure', $snowFigure)
            ->orderBy('s.createdAt', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery()
        ;

        return new Paginator($query);
    }

    // /**
    //  * @return SnowComment[] Returns an array of SnowComment objects
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
    public function findOneBySomeField($value): ?SnowComment
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
