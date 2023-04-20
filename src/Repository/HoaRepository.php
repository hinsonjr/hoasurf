<?php

namespace App\Repository;

use App\Entity\Hoa;
use App\Entity\Accounting\LedgerAccount;
use App\Entity\Accounting\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hoa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hoa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hoa[]    findAll()
 * @method Hoa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HoaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hoa::class);
    }
	
	public function findTransactions(Hoa $hoa, $cnt)
	{
		$entityManager = $this->getEntityManager();
        $query = $entityManager->createQueryBuilder();
        $query->select('t.debitAccount, t.creditAccount,t.amount');
        $query->from('Transaction', 't');
        $query->join('LedgerAccount','a')->where('a.hoa = :hoaId && (a.id = t.debitAccount || a.id = t.creditAccount)');
        $transactions = $query->getQuery()->getResult();
        return $transactions;
	}

    // /**
    //  * @return Hoa[] Returns an array of Hoa objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hoa
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
