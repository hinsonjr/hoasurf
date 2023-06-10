<?php

/*
 * This software is copyright to Hinson Stephens of Just Biz, Inc.
 * Please contact hinsonjr@justbiz.biz for information about the software.
 */

namespace App\EventListener;

/**
 * Description of RequestEntityListener
 *
 * @author hinso
 */

use App\Entity\Request;
use App\Entity\RequestStatus;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Request::class)]
class RequestEntityListener
{
	private $tokenStorage;
	
	public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
	
	public function prePersist(Request $request, LifecycleEventArgs $args)
	{
		$user = $this->tokenStorage->getToken()->getUser();
		$entity = $args->getObjectManager();
		$statusRepo = $entity->getRepository(RequestStatus::class);
		$request->setStatus($statusRepo->findOneByStatus("Created"));
		$request->setCreatedby($user);
	}
}
