<?php

namespace App\Repository;

use App\Entity\RegroupementModule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RegroupementModule|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegroupementModule|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegroupementModule[]    findAll()
 * @method RegroupementModule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegroupementModuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegroupementModule::class);
    }

    // /**
    //  * @return RegroupementModule[] Returns an array of RegroupementModule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RegroupementModule
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
