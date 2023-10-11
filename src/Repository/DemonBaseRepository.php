<?php

namespace App\Repository;

use App\Entity\DemonBase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemonBase>
 *
 * @method DemonBase|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemonBase|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemonBase[]    findAll()
 * @method DemonBase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemonBaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemonBase::class);
    }

//    /**
//     * @return DemonBase[] Returns an array of DemonBase objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DemonBase
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
