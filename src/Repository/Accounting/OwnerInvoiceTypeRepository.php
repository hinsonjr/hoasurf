<?php

namespace App\Repository\Accounting;

use App\Entity\Accounting\OwnerInvoiceType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OwnerInvoiceType>
 *
 * @method OwnerInvoiceType|null find($id, $lockMode = null, $lockVersion = null)
 * @method OwnerInvoiceType|null findOneBy(array $criteria, array $orderBy = null)
 * @method OwnerInvoiceType[]    findAll()
 * @method OwnerInvoiceType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnerInvoiceTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OwnerInvoiceType::class);
    }

    public function save(OwnerInvoiceType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OwnerInvoiceType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return OwnerInvoiceType[] Returns an array of OwnerInvoiceType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OwnerInvoiceType
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
