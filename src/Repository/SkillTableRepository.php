<?php

namespace App\Repository;

use App\Entity\SkillTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SkillTable>
 *
 * @method SkillTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillTable[]    findAll()
 * @method SkillTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillTable::class);
    }

    public function findSkillsBelowOrEqualToLevel(?int $level, int $idDemon)
    {
        return $this->createQueryBuilder('st')
        ->andWhere('st.level <= :level')
        ->andWhere('st.demonBase = :idDemon')
        ->setParameters([
            'level' => $level,
            'idDemon' => $idDemon
        ])
        ->getQuery()
        ->getResult();
    }

//    /**
//     * @return SkillTable[] Returns an array of SkillTable objects
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

//    public function findOneBySomeField($value): ?SkillTable
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
