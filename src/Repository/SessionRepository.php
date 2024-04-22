<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

       /**
        * @return Session[] Returns an array of Session objects
        */
       public function findSessionsPassees($value): array
       {
           return $this->createQueryBuilder('s')
               ->andWhere('s.dateFin < :val')
               ->setParameter('val', $value)
               ->orderBy('s.dateFin', 'DESC')
               ->setMaxResults(null)
               ->getQuery()
               ->getResult()
           ;
       }

              /**
        * @return Session[] Returns an array of Session objects
        */
        public function findSessionsEnCours($value): array
        {
            return $this->createQueryBuilder('s')
                ->andWhere(':val >= s.dateDebut')
                ->andWhere(':val <= s.dateFin')
                ->setParameter('val', $value)
                ->orderBy('s.dateFin', 'DESC')
                ->setMaxResults(null)
                ->getQuery()
                ->getResult()
            ;
        }

        public function findSessionsPrevues($value): array
        {
            return $this->createQueryBuilder('s')
                ->andWhere(':val < s.dateDebut')
                ->setParameter('val', $value)
                ->orderBy('s.dateFin', 'ASC')
                ->setMaxResults(null)
                ->getQuery()
                ->getResult()
            ;
        }

        public function StagiairesNonInscrits($session_id)
    {
        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        $qb = $sub;
        // sélectionner tous les stagiaires d'une session dont l'id est passé en paramètre
        $qb->select('s')
            ->from('App\Entity\Stagiaire', 's')
            ->leftJoin('s.sessions', 'se')
            ->where('se.id = :id');
        
        $sub = $em->createQueryBuilder();
        // sélectionner tous les stagiaires qui ne SONT PAS (NOT IN) dans le résultat précédent
        // on obtient donc les stagiaires non inscrits pour une session définie
        $sub->select('st')
            ->from('App\Entity\Stagiaire', 'st')
            ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
            // requête paramétrée
            ->setParameter('id', $session_id)
            // trier la liste des stagiaires sur le nom de famille
            ->orderBy('st.nom');
        
        // renvoyer le résultat
        $query = $sub->getQuery();
        return $query->getResult();
    }

    //    public function findOneBySomeField($value): ?Session
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
