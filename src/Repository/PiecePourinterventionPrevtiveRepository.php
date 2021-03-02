<?php

namespace App\Repository;

use App\Entity\PiecePourinterventionPrevtive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PiecePourinterventionPrevtive|null find($id, $lockMode = null, $lockVersion = null)
 * @method PiecePourinterventionPrevtive|null findOneBy(array $criteria, array $orderBy = null)
 * @method PiecePourinterventionPrevtive[]    findAll()
 * @method PiecePourinterventionPrevtive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PiecePourinterventionPrevtiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PiecePourinterventionPrevtive::class);
    }

    // /**
    //  * @return PiecePourinterventionPrevtive[] Returns an array of PiecePourinterventionPrevtive objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PiecePourinterventionPrevtive
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
