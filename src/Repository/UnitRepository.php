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
    public function findAll($query = [])
    {
		$buildingId = "";
		$search = "";
		$q = $this->createQueryBuilder('u')
            ->setMaxResults(50)
			->orderBy('u.unitNumber');

		if (array_key_exists('search',$query) && $query['search'])
		{
            $q->andWhere("u.unitNumber like :sval")
				->setParameter('sval','%'.$query['search'].'%' );
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
		$query = $em->createQuery(
            'SELECT o
            FROM App\Entity\Owner o
			WHERE o.unit = :id AND o.startDate IS NOT NULL and (o.endDate IS NULL or o.endDate >= CURRENT_TIMESTAMP())
			ORDER BY o.startDate'
        )->setParameter('id', $unitId);
		$owners = (array) $query->getResult();
		return $owners;
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
