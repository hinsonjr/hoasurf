<?php

namespace App\Repository\Accounting;

use App\Entity\Accounting\Transaction;
use App\Entity\Accounting\LedgerAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }
	
	public function findAll()
	{
		$q = $this->createQueryBuilder('t')
            ->setMaxResults(50)
			->andWhere("t.deleted != true")
			->orderBy('t.date', 'DESC');

		$transactions =  $q->getQuery()
            ->getResult();
		
		return $transactions;
	}
	
    public function findByLedgerAccount($ledgerAcctId, $type=null)
    {
        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.creditAccount = :val OR t.debitAccount = :val ')
            ->setParameter('val', $ledgerAcctId)
            ->orderBy('t.date', 'DESC')
            ->setMaxResults(30)
            ->getQuery()
            
        ;
		return $qb->getResult();
    }
	
	public function findByDate($limit = 10)
	{
		return $this->createQueryBuilder('t')
            ->andWhere('t.deleted = 0')
            ->orderBy('t.date', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
	}
    // /**
    //  * @return Transaction[] Returns an array of Transaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Transaction
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
