<?php

namespace App\Repository;

use App\Entity\RequestType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RequestType>
 *
 * @method RequestType|null find($id, $lockMode = null, $lockVersion = null)
 * @method RequestType|null findOneBy(array $criteria, array $orderBy = null)
 * @method RequestType[]    findAll()
 * @method RequestType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestTypeRepository extends ServiceEntityRepository
{

	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, RequestType::class);
	}

	public function save(RequestType $entity, bool $flush = false): void
	{
		$this->getEntityManager()->persist($entity);

		if ($flush)
		{
			$this->getEntityManager()->flush();
		}
	}

	public function remove(RequestType $entity, bool $flush = false): void
	{
		$this->getEntityManager()->remove($entity);

		if ($flush)
		{
			$this->getEntityManager()->flush();
		}
	}

//    /**
//     * @return RequestTypes[] Returns an array of RequestTypes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
//    public function findOneBySomeField($value): ?RequestTypes
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
