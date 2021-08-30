<?php

namespace App\Repository;

use App\Entity\VideoFigure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoFigure|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoFigure|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoFigure[]    findAll()
 * @method VideoFigure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoFigureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoFigure::class);
    }

    // /**
    //  * @return VideoFigure[] Returns an array of VideoFigure objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VideoFigure
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
