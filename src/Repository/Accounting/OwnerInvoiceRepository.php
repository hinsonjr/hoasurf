<?php

namespace App\Repository\Accounting;

use App\Entity\Accounting\OwnerInvoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OwnerInvoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method OwnerInvoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method OwnerInvoice[]    findAll()
 * @method OwnerInvoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnerInvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OwnerInvoice::class);
    }

    // /**
    //  * @return OwnerInvoice[] Returns an array of OwnerInvoice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OwnerInvoice
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
