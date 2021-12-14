<?php

namespace App\Repository\Accounting;

use App\Entity\Accounting\OwnerAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OwnerAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method OwnerAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method OwnerAccount[]    findAll()
 * @method OwnerAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnerAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OwnerAccount::class);
    }

    // /**
    //  * @return OwnerAccount[] Returns an array of OwnerAccount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OwnerAccount
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
