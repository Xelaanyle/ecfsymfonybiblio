<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * @return Livre[] Returns an array of Livre objects
     */
    public function findByAlphabetiqueOrder(): array
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Livre[] Returns an array of Livre objects
     */
    public function findByKeywordLorem(string $keyword): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.titre LIKE :keyword')
            ->setParameter('keyword', "%$keyword%")
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Livre[] Returns an array of Livre objects
     */

    public function findByGenreKeyword(): array
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.genres', 'g')
            ->andWhere('g.nom LIKE :nom')
            ->setParameter('nom', '%roman%')
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Livre[] Returns an array of Livre objects
     */

    public function findByAuteurId(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.auteur = :auteur')
            ->setParameter('auteur', '2')
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Livre[] Returns an array of Livre objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Livre
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
