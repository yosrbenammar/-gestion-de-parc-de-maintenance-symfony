<?php

namespace App\Repository;

use App\Entity\FicheDemontage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FicheDemontage|null find($id, $lockMode = null, $lockVersion = null)
 * @method FicheDemontage|null findOneBy(array $criteria, array $orderBy = null)
 * @method FicheDemontage[]    findAll()
 * @method FicheDemontage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheDemontageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FicheDemontage::class);
    }

    // /**
    //  * @return FicheDemontage[] Returns an array of FicheDemontage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FicheDemontage
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
