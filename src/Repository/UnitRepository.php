<?php

namespace App\Repository;

use App\Entity\Unit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Unit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unit::class);
    }

    // /**
    //  * @return Unit[] Returns an array of Unit objects
    //  */
    public function findAll($query = []): array
    {
		$buildingId = "";
		$search = "";
		$q = $this->createQueryBuilder('u')
            ->setMaxResults(50)
			->orderBy('u.unitNumber');

		if (array_key_exists('unitSearch',$query) && $query['unitSearch'])
		{
			$q->andWhere("u.unitNumber like :sval");
			$q->setParameter('sval','%'.$query['unitSearch'].'%' );
		}
		if (array_key_exists('buildingId',$query) && $query['buildingId'])
		{
            $q->andWhere('u.building = :val')
				->setParameter('val',$query['buildingId'] );
		}
		$units =  $q->getQuery()
            ->getResult();
		
		return $units;

    }

    public function findCurrentOwners($unitId)
    {
		$em = $this->getEntityManager();
//		$query = $em->createQuery(
//            'SELECT o
//            FROM App\Entity\Owner o
//			JOIN App\Entity\Unit u
//			on u.unitId = :id
//			WHERE o.startDate IS NOT NULL and (o.endDate IS NULL or o.endDate >= CURRENT_TIMESTAMP())
//			ORDER BY o.startDate'
		$owners = $this->createQueryBuilder('o')
			->innerJoin('o.units','u', 'WITH', 'u.unit_id = :id')
	        ->setParameter('id', $unitId)
			->where('o.startDate IS NOT NULL and (o.endDate IS NULL or o.endDate >= CURRENT_TIMESTAMP())')
			->getQuery()
            ->getResult();
		return (array) $owners;
	}

    /*
    public function findOneBySomeField($value): ?Unit
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
