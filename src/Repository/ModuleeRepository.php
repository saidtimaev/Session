<?php

namespace App\Repository;

use App\Entity\Modulee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Modulee>
 *
 * @method Modulee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Modulee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Modulee[]    findAll()
 * @method Modulee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Modulee::class);
    }

    //    /**
    //     * @return Modulee[] Returns an array of Modulee objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Modulee
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
