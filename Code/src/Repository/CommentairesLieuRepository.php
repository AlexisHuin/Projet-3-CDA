<?php

namespace App\Repository;

use App\Entity\CommentairesLieu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommentairesLieu>
 *
 * @method CommentairesLieu|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentairesLieu|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentairesLieu[]    findAll()
 * @method CommentairesLieu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentairesLieuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentairesLieu::class);
    }

//    /**
//     * @return CommentairesLieu[] Returns an array of CommentairesLieu objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CommentairesLieu
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
