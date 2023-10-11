<?php

namespace App\Repository;

use App\Entity\HaveItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HaveItem>
 *
 * @method HaveItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method HaveItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method HaveItem[]    findAll()
 * @method HaveItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HaveItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HaveItem::class);
    }

//    /**
//     * @return HaveItem[] Returns an array of HaveItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HaveItem
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
