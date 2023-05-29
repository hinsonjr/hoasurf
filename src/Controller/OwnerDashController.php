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
use App\Entity\Accounting\OwnerInvoice;

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
		$ownerInvoiceRepo = $this->doctrine->getRepository(OwnerInvoice::class);
		$invoiceRecords = [];
		foreach ($ownerRecords as $ownerRecord)
		{
			$invoices = $ownerInvoiceRepo->findByOwner($ownerRecord);
			foreach ($invoices as $invoice)
			{
				echo "Invoice count for " . $unitOwner->getOwner()->getName() . " " . count($invoices) . "<br>";
				$invoiceRecords[$unitOwner->getUnit()->getUnitNumber()] = $ownerInvoiceRepo->findByOwner($unitOwner->getUnit());
			}
		}
        return $this->render('owner_dash/index.html.twig', [
            'controller_name' => 'OwnerDashController',
			'owner_records' => $ownerRecords,
			'owner_messages' => $ownerMessages,
			'invoice_records' => $invoiceRecords,
			'service_requests' => $serviceRequests
        ]);
    }
}
