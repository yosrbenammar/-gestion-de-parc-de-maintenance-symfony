<?php

namespace App\Repository;

use App\Entity\PiecePourPreventive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PiecePourPreventive|null find($id, $lockMode = null, $lockVersion = null)
 * @method PiecePourPreventive|null findOneBy(array $criteria, array $orderBy = null)
 * @method PiecePourPreventive[]    findAll()
 * @method PiecePourPreventive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PiecePourPreventiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PiecePourPreventive::class);
    }

    // /**
    //  * @return PiecePourPreventive[] Returns an array of PiecePourPreventive objects
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
    public function findOneBySomeField($value): ?PiecePourPreventive
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
