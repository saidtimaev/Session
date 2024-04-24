<?php

namespace App\Repository;

use App\Entity\Formateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Formateur>
 *
 * @method Formateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formateur[]    findAll()
 * @method Formateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formateur::class);
    }


    public function NbSessionsFormateurs($dateActuelle)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT formateur.id, nom, prenom,
        ( SELECT COUNT(session.id) FROM session WHERE session.formateur_id = formateur.id AND session.date_debut > :dateActuelle) as sessionsPrevues,
        ( SELECT COUNT(session.id) FROM session WHERE session.formateur_id = formateur.id AND session.date_debut < :dateActuelle AND session.date_fin > :dateActuelle) as sessionsEnCours,
        ( SELECT COUNT(session.id) FROM session WHERE session.formateur_id = formateur.id AND session.date_fin < :dateActuelle) as sessionsPassees
        FROM formateur
        ';

        $resultSet = $conn->executeQuery($sql, ['dateActuelle' => $dateActuelle]);

        return $resultSet->fetchAllAssociative();

    }

    //    /**
    //     * @return Formateur[] Returns an array of Formateur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Formateur
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
