<?php

namespace App\Repository;

use App\Entity\DemonPlayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemonPlayer>
 *
 * @method DemonPlayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemonPlayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemonPlayer[]    findAll()
 * @method DemonPlayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemonPlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemonPlayer::class);
    }

//    /**
//     * @return DemonPlayer[] Returns an array of DemonPlayer objects
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

//    public function findOneBySomeField($value): ?DemonPlayer
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
