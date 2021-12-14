<?php

namespace App\Repository\Accounting;

use App\Entity\Accounting\LedgerAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LedgerAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method LedgerAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method LedgerAccount[]    findAll()
 * @method LedgerAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LedgerAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LedgerAccount::class);
    }

    // /**
    //  * @return LedgerAccount[] Returns an array of LedgerAccount objects
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
    public function findOneBySomeField($value): ?LedgerAccount
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
