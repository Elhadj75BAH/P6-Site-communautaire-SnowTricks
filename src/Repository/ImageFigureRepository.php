<?php

namespace App\Repository;

use App\Entity\ImageFigure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageFigure|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageFigure|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageFigure[]    findAll()
 * @method ImageFigure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageFigureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageFigure::class);
    }

    // /**
    //  * @return ImageFigure[] Returns an array of ImageFigure objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageFigure
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
