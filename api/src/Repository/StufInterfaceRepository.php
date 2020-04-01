<?php

namespace App\Repository;

use App\Entity\StufInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StufInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method StufInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method StufInterface[]    findAll()
 * @method StufInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StufInterfaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StufInterface::class);
    }

    // /**
    //  * @return StufInterface[] Returns an array of StufInterface objects
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
    public function findOneBySomeField($value): ?StufInterface
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
