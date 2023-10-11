<?php

namespace App\Repository;

use App\Entity\Batle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Batle>
 *
 * @method Batle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Batle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Batle[]    findAll()
 * @method Batle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BatleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Batle::class);
    }

//    /**
//     * @return Batle[] Returns an array of Batle objects
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

//    public function findOneBySomeField($value): ?Batle
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
