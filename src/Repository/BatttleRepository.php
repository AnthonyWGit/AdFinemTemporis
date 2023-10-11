<?php

namespace App\Repository;

use App\Entity\Batttle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Batttle>
 *
 * @method Batttle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Batttle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Batttle[]    findAll()
 * @method Batttle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BatttleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Batttle::class);
    }

//    /**
//     * @return Batttle[] Returns an array of Batttle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Batttle
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
