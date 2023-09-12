<?php

namespace App\Repository;

use App\Entity\Emprunteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunteur>
 *
 * @method Emprunteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunteur[]    findAll()
 * @method Emprunteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmprunteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunteur::class);
    }


    /**
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */
    public function findByEmprunteur(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.nom', 'ASC')
            ->addOrderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */

    public function findByEmprunteurFoo(): array
    {
        return $this->createQueryBuilder('e')
            ->Where('e.nom LIKE :search')
            ->andWhere('e.prenom LIKE :search')
            ->setParameter('search', '%foo%')
            ->orderBy('e.nom', 'ASC')
            ->addOrderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */

    public function findByEmprunteurTel(): array
    {
        return $this->createQueryBuilder('e')
            ->Where('e.tel LIKE :tel')
            ->setParameter('tel', '%1234%')
            ->orderBy('e.nom', 'ASC')
            ->addOrderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */

    public function findByDate(): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.createdAt < :dateLimite')
            ->setParameter('dateLimite', '2021-03-01')
            ->orderBy('e.nom', 'ASC')
            ->addOrderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findEmprunteurByUserId($userId)
    {

        return $this->createQueryBuilder('e')
            ->innerJoin('e.user', 'u')
            ->andWhere('u.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleResult();
    }
    
    //    public function findOneBySomeField($value): ?Emprunteur
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
