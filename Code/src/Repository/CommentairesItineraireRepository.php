<?php

namespace App\Repository;

use App\Entity\CommentairesItineraire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommentairesItineraire>
 *
 * @method CommentairesItineraire|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentairesItineraire|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentairesItineraire[]    findAll()
 * @method CommentairesItineraire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentairesItineraireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentairesItineraire::class);
    }

//    /**
//     * @return CommentairesItineraire[] Returns an array of CommentairesItineraire objects
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

//    public function findOneBySomeField($value): ?CommentairesItineraire
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
