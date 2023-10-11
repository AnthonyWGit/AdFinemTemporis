<?php

namespace App\Repository;

use App\Entity\SkillLearnable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SkillLearnable>
 *
 * @method SkillLearnable|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillLearnable|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillLearnable[]    findAll()
 * @method SkillLearnable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillLearnableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillLearnable::class);
    }

//    /**
//     * @return SkillLearnable[] Returns an array of SkillLearnable objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SkillLearnable
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
