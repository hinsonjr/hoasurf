<?php

namespace App\Repository;

use App\Entity\Debug;
use App\Entity\Setting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @method Debug|null find($id, $lockMode = null, $lockVersion = null)
 * @method Debug|null findOneBy(array $criteria, array $orderBy = null)
 * @method Debug[]    findAll()
 * @method Debug[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DebugRepository extends ServiceEntityRepository
{
    public function __construct()
    {
        //parent::__construct();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Debug $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Debug $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}