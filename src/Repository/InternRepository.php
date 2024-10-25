<?php

namespace App\Repository;

use App\Entity\Intern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Intern>
 */
class InternRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intern::class);
    }

    //    /**
    //     * @return Intern[] Returns an array of Intern objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Intern
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findNonInscrits($session_id)
{
    $em = $this->getEntityManager();

    // Sous-requête pour obtenir les stagiaires déjà inscrits dans la session
    $sub = $em->createQueryBuilder();
    $sub->select('s.id')
        ->from('App\Entity\Intern', 's')
        ->leftJoin('s.sessions', 'se')
        ->where('se.id = :id');

    // Requête principale pour obtenir les stagiaires qui ne sont PAS dans la session
    $qb = $em->createQueryBuilder();
    $qb->select('st')
        ->from('App\Entity\Intern', 'st')
        ->where($qb->expr()->notIn('st.id', $sub->getDQL())) // Exclure les stagiaires inscrits
        ->setParameter('id', $session_id)
        ->orderBy('st.lastName', 'ASC'); // Trier par nom

    return $qb->getQuery()->getResult();
}


}
