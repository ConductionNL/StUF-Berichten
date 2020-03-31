<?php

namespace App\Repository;

use App\Entity\StufMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StufMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method StufMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method StufMessage[]    findAll()
 * @method StufMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StufMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StufMessage::class);
    }

    // /**
    //  * @return StufMessage[] Returns an array of StufMessage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StufMessage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
