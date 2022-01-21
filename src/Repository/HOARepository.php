<?php

namespace App\Repository;

use App\Entity\HOA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HOA|null find($id, $lockMode = null, $lockVersion = null)
 * @method HOA|null findOneBy(array $criteria, array $orderBy = null)
 * @method HOA[]    findAll()
 * @method HOA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HOARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HOA::class);
    }

	public function findHoaUnitOwners($hoa)
	{
		$buildings = $hoa->getBuildings();
		$owners = [];
		foreach ($buildings as $building)
		{
			$units = $building->getUnits();
			foreach ($units as $unit)
			{
				$owners[$unit->getUnitNumber()] = $unit->getCurrentOwner();
			}
		}
		
	}

}
