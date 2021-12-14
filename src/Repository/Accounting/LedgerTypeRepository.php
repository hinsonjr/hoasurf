<?php

namespace App\Repository\Accounting;

use App\Entity\Accounting\LedgerType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LedgerType|null find($id, $lockMode = null, $lockVersion = null)
 * @method LedgerType|null findOneBy(array $criteria, array $orderBy = null)
 * @method LedgerType[]    findAll()
 * @method LedgerType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LedgerTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LedgerType::class);
    }

    // /**
    //  * @return LedgerType[] Returns an array of LedgerType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LedgerType
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
