<?php

namespace App\Repository;

use App\Entity\Emprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunt>
 *
 * @method Emprunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunt[]    findAll()
 * @method Emprunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunt::class);
    }

    /**
     * @return Emprunt[] Returns an array of Emprunt objects
     */
    public function findLast10Emprunts(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.dateEmprunt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Emprunt[] Returns an array of Emprunt objects
     */

    public function findEmpruntsByEmprunteurId(): array
    {

        return $this->createQueryBuilder('e')
            ->andWhere('e.emprunteur = :emprunteurId')
            ->setParameter('emprunteurId', '2')
            ->orderBy('e.dateEmprunt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Emprunt[] Returns an array of Emprunt objects
     */

    public function findEmpruntsByLivreId(): array
    {

        return $this->createQueryBuilder('e')
            ->andWhere('e.livre = :livreId')
            ->setParameter('livreId', '3')
            ->orderBy('e.dateEmprunt', 'DESC') // Tri décroissant par date d'emprunt
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Emprunt[] Returns an array of Emprunt objects
     */
    public function findLast10EmpruntsReturn(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.dateRetour', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findEmpruntsNotReturn()
    {

        return $this->createQueryBuilder('e')
            ->andWhere('e.dateRetour IS NULL')
            ->orderBy('e.dateEmprunt', 'ASC')
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return Emprunt[] Returns an array of Emprunt objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Emprunt
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
