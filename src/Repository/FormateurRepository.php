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


    // public function NbSessionsFormateurs($dateActuelle)
    // {
    //     $conn = $this->getEntityManager()->getConnection();

    //     $sql = '
    //         SELECT stagiaire_id as id, nom, prenom,
    //         (SELECT COUNT(*) FROM session_stagiaire INNER JOIN session ON session_stagiaire.session_id = session.id WHERE stagiaire_id = stagiaire.id AND date_debut < :dateActuelle AND date_fin > :dateActuelle GROUP BY stagiaire_id) AS sessionEnCours,
    //         (SELECT COUNT(*) FROM session_stagiaire INNER JOIN session ON session_stagiaire.session_id = session.id WHERE stagiaire_id = stagiaire.id AND date_fin < :dateActuelle GROUP BY stagiaire_id) AS sessionPassees,
    //         (SELECT COUNT(*) FROM session_stagiaire INNER JOIN session ON session_stagiaire.session_id = session.id WHERE stagiaire_id = stagiaire.id AND date_debut > :dateActuelle GROUP BY stagiaire_id) AS sessionPrevues
    //         FROM session_stagiaire
    //         INNER JOIN session ON session_stagiaire.session_id = session.id
    //         INNER JOIN stagiaire ON session_stagiaire.stagiaire_id = stagiaire.id
    //         GROUP BY stagiaire_id
    //         ORDER BY nom ASC
    //     ';

    //     $resultSet = $conn->executeQuery($sql, ['dateActuelle' => $dateActuelle]);

    //     return $resultSet->fetchAllAssociative();

    // }

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
