<?php

namespace App\Repository;

use App\Entity\DemonTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemonTrait>
 *
 * @method DemonTrait|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemonTrait|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemonTrait[]    findAll()
 * @method DemonTrait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemonTraitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemonTrait::class);
    }

//    /**
//     * @return DemonTrait[] Returns an array of DemonTrait objects
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

//    public function findOneBySomeField($value): ?DemonTrait
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
