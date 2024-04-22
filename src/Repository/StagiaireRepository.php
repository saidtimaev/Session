<?php

namespace App\Repository;

use App\Entity\Stagiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\GroupBy;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stagiaire>
 *
 * @method Stagiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stagiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stagiaire[]    findAll()
 * @method Stagiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StagiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stagiaire::class);
    }


    
    public function NbSessionsStagiaires($dateActuelle)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT stagiaire_id as id, nom, prenom,
            (SELECT COUNT(*) FROM session_stagiaire INNER JOIN session ON session_stagiaire.session_id = session.id WHERE stagiaire_id = stagiaire.id AND date_debut < :dateActuelle AND date_fin > :dateActuelle GROUP BY stagiaire_id) AS sessionEnCours,
            (SELECT COUNT(*) FROM session_stagiaire INNER JOIN session ON session_stagiaire.session_id = session.id WHERE stagiaire_id = stagiaire.id AND date_fin < :dateActuelle GROUP BY stagiaire_id) AS sessionPassees,
            (SELECT COUNT(*) FROM session_stagiaire INNER JOIN session ON session_stagiaire.session_id = session.id WHERE stagiaire_id = stagiaire.id AND date_debut > :dateActuelle GROUP BY stagiaire_id) AS sessionPrevues
            FROM session_stagiaire
            INNER JOIN session ON session_stagiaire.session_id = session.id
            INNER JOIN stagiaire ON session_stagiaire.stagiaire_id = stagiaire.id
            GROUP BY stagiaire_id
            ORDER BY nom ASC
        ';

        $resultSet = $conn->executeQuery($sql, ['dateActuelle' => $dateActuelle]);

        return $resultSet->fetchAllAssociative();

    }
    

    //    /**
    //     * @return Stagiaire[] Returns an array of Stagiaire objects
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

    //    public function findOneBySomeField($value): ?Stagiaire
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
