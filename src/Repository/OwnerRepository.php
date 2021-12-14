<?php

namespace App\Repository;

use App\Entity\Owner;
use App\Entity\Unit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Owner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Owner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Owner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Owner::class);
    }

    // /**
    //  * @return Owner[] Returns an array of Owner objects
    //  */

    public function findAll($query = [])
	{
		$search = "";
		$q = $this->createQueryBuilder('o')
			->join("o.unit","u")
            ->setMaxResults(25)
			->orderBy('u.unitNumber');

		if (array_key_exists('search',$query) && $query['search'])
		{
            $q->orWhere("o.name like :nval","u.unitNumber like :nval")
				->setParameter('nval','%'.$query['search'].'%' );
		}
		//var_dump($q->getQuery());

		$owners = $q->getQuery()
            ->getResult();
		
		return (array) $owners;
	
	}
	
	public function findOwnerUnits($ownerId)
	{
		$q = $this->createQueryBuilder('p')
			->from("Units")
			->where("Unit.ownerId = ".$ownerId)
			->orderBy('u.unitNumber');
	}

	public function findHoaCurrentOwners($hoaId)
	{
		$date = new DateTime();
		$q = $this->createQueryBuilder('o')
			->join("o.unit","u")
			->join("u.building","b","WITH",'b.id = ?1')
			->andWhere(isNotNull('o.start_date'),orX(isNull('o.end_date'),gte('o.endDate',$date->format("Y-m-d"))))
			->setParameter(1,$hoaId)
			->orderBy('u.unitNumber');
	}
	
}
