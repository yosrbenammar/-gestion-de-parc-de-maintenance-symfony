<?php

namespace App\Repository;

use App\Entity\PiecesPourIntervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PiecesPourIntervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method PiecesPourIntervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method PiecesPourIntervention[]    findAll()
 * @method PiecesPourIntervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PiecesPourInterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PiecesPourIntervention::class);
    }

    // /**
    //  * @return PiecesPourIntervention[] Returns an array of PiecesPourIntervention objects
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
    public function findOneBySomeField($value): ?PiecesPourIntervention
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
