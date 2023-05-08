<?php

namespace App\Repository;

use App\Entity\AccountingLedgerAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccountingLedgerAccount>
 *
 * @method AccountingLedgerAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountingLedgerAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountingLedgerAccount[]    findAll()
 * @method AccountingLedgerAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountingLedgerAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountingLedgerAccount::class);
    }

    public function save(AccountingLedgerAccount $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AccountingLedgerAccount $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AccountingLedgerAccount[] Returns an array of AccountingLedgerAccount objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AccountingLedgerAccount
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
