<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use App\Entity\Owner;
use App\Entity\Message;

class OwnerDashController extends AbstractController
{
	private $security;
	
	public function __construct(Security $security, ManagerRegistry $doctrine)
	{
		$this->security = $security;
		$this->doctrine = $doctrine;
	}
	
    #[Route('/owner/dash', name: 'owner_dash')]
    public function index(): Response
    {
		$ownerRepo = $this->doctrine->getRepository(Owner::class);
		$ownerRecords = $ownerRepo->findByUser($this->security->getUser());
		$msgRepo = $this->doctrine->getRepository(Message::class);
		$ownerMessages= $msgRepo->findOwnerMessages($this->security->getUser());
		$serviceRequests = [];
		$paymentRecords = [];
        return $this->render('owner_dash/index.html.twig', [
            'controller_name' => 'OwnerDashController',
			'owner_records' => $ownerRecords,
			'owner_messages' => $ownerMessages,
			'payment_records' => $paymentRecords,
			'service_requests' => $serviceRequests
        ]);
    }
}
