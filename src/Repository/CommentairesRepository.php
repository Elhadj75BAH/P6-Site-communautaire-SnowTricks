<?php

namespace App\Repository;

use App\Entity\Commentaires;
use App\Entity\Figure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaires[]    findAll()
 * @method Commentaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaires::class);
    }

    public function paginationCommentaire($page,$figure)
    {

        return $this->createQueryBuilder('c')
            ->orderBy('c.dateDuCommentaire', 'DESC')
            ->setMaxResults(3)
            ->where('c.figure=?1')
            ->setParameter(1,$figure)
            ->setFirstResult(($page-1)*2)
            ->getQuery()
            ->getResult()
            ;
    }



    // /**
    //  * @return Commentaires[] Returns an array of Commentaires objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

*/
    /*
    public function findOneBySomeField($value): ?Commentaires
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
