<?php

namespace App\Controller\Owner;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use App\Entity\Owner;
use App\Entity\UnitOwner;
use App\Entity\Message;
use App\Entity\Accounting\OwnerInvoice;
use App\Repository\MessageRepository;
use App\Repository\RequestRepository;
use App\Form\Owner\MessageOwnerReply;
use App\Form\Owner\RequestOwnerReply;

class OwnerSelfController extends AbstractController
{
	public function __construct(Security $security, ManagerRegistry $doctrine)
	{
		$this->security = $security;
		$this->doctrine = $doctrine;
	}

    #[Route('/owner/dash', name: 'owner_dash')]
    public function index(): Response
    {
		$ownerRepo = $this->doctrine->getRepository(Owner::class);
		$owner = $ownerRepo->findOneByUser($this->security->getUser());
//        echo "Owner Id: " . $owner->getId() . "<br>";
        
		$unitOwnerRepo = $this->doctrine->getRepository(UnitOwner::class);
        $unitsOwned = $unitOwnerRepo->findByOwner($owner);
		$msgRepo = $this->doctrine->getRepository(Message::class);
		$ownerMessages= $msgRepo->findOwnerMessages($this->security->getUser());
		$ownerInvoiceRepo = $this->doctrine->getRepository(OwnerInvoice::class);
		$requestRepo = $this->doctrine->getRepository(\App\Entity\Request::class);
        $serviceRequests = [];
        $invoiceRecords = [];
		foreach ($unitsOwned as $unitOwned)
        {

    		$serviceRequests = array_merge($serviceRequests, $requestRepo->findByUnit($unitOwned->getUnit()));
			$invoices = $ownerInvoiceRepo->findByUnitOwner($unitOwned);
			foreach ($invoices as $invoice)
			{
//                echo "Found an invoice: " . $invoice->getAmount() . "<br>";
				$invoiceRecords[$unitOwned->getUnit()->getUnitNumber()][] = $invoice;
			}
		}
        return $this->render('owner_self/index.html.twig', [
            'controller_name' => 'OwnerDashController',
			'owner_records' => $unitsOwned,
			'owner_messages' => $ownerMessages,
			'invoice_records' => $invoiceRecords,
			'requests' => $serviceRequests
        ]);
    }
    
    #[Route('/owner/payments', name: 'owner_payments')]
    public function payments(): Response
    {
		$ownerRepo = $this->doctrine->getRepository(Owner::class);
		$ownerInvoiceRepo = $this->doctrine->getRepository(OwnerInvoice::class);
		$owner = $ownerRepo->findOneByUser($this->security->getUser());
//        echo "Owner Id: " . $owner->getId() . "<br>";
        
		$unitOwnerRepo = $this->doctrine->getRepository(UnitOwner::class);
        $unitsOwned = $unitOwnerRepo->findByOwner($owner);
        foreach ($unitsOwned as $unitOwned)
        {
//            echo "Unit Owned: " . $unitOwned->getUnit()->getId() . "<br>";
        }
        $invoiceRecords = [];
        $today = new \DateTime();
		foreach ($unitsOwned as $unitOwned)
		{
			$invoices = $ownerInvoiceRepo->findByUnitOwner($unitOwned);
			foreach ($invoices as $invoice)
			{
//                echo "Found an invoice: " . $invoice->getAmount() . "<br>";
                if ($today > $invoice->getPostDate())
                {
        			$invoiceRecords[$unitOwned->getUnit()->getUnitNumber()][] = $invoice;
                }
			}
		}
        return $this->render('owner_self/invoices.html.twig', [
            'controller_name' => 'OwnerDashController',
			'owner_records' => $unitsOwned,
			'invoice_records' => $invoiceRecords
        ]);
    }
    
    #[Route('/owner/requests', name: 'owner_requests')]
    public function requests(): Response
    {
		$ownerRepo = $this->doctrine->getRepository(Owner::class);
		$owner = $ownerRepo->findOneByUser($this->security->getUser());
        echo "Owner Id: " . $owner->getId() . "<br>";
        
		$unitOwnerRepo = $this->doctrine->getRepository(UnitOwner::class);
        $unitsOwned = $unitOwnerRepo->findByOwner($owner);
        foreach ($unitsOwned as $unitOwned)
        {
            echo "Unit Owned: " . $unitOwned->getUnit()->getId() . "<br>";
        }
		$msgRepo = $this->doctrine->getRepository(Message::class);
		$ownerMessages= $msgRepo->findOwnerMessages($this->security->getUser());
		$ownerInvoiceRepo = $this->doctrine->getRepository(OwnerInvoice::class);
		$requestRepo = $this->doctrine->getRepository(\App\Entity\Request::class);
        $serviceRequests = [];
        foreach ($unitsOwned as $unit)
        {
    		$serviceRequests = array_merge($serviceRequests, $requestRepo->findByUnit($unit->getUnit()));
        }

        return $this->render('owner_self/requests.html.twig', [
            'controller_name' => 'OwnerDashController',
			'owner_records' => $unitsOwned,
			'owner_requests' => $serviceRequests
        ]);
    }    

    #[Route('/owner/messages', name: 'owner_messages')]
    public function messages(): Response
    {
		$ownerRepo = $this->doctrine->getRepository(Owner::class);
		$owner = $ownerRepo->findOneByUser($this->security->getUser());
        
		$unitOwnerRepo = $this->doctrine->getRepository(UnitOwner::class);
        $unitsOwned = $unitOwnerRepo->findByOwner($owner);
		$msgRepo = $this->doctrine->getRepository(Message::class);
		$ownerMessages= $msgRepo->findOwnerMessages($this->security->getUser());

        return $this->render('owner_self/messages.html.twig', [
            'controller_name' => 'OwnerDashController',
			'owner_records' => $unitsOwned,
			'owner_messages' => $ownerMessages
        ]);
    }    
    
    
    #[Route('/owner/message/{parent}/reply', name: 'app_message_reply', methods: ['GET', 'POST'])]
    public function messageReply(Request $request, MessageRepository $messageRepository, Message $parent = null): Response
    {
        $form = $this->createForm(MessageOwnerReply::class, $parent);
        $form->handleRequest($request);
        $message = clone $parent;
        $message->setBody("");
        if ($form->isSubmitted() && $form->isValid()) {
			$message->setParent($parent);
            $messageRepository->save($message, true);

            return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('owner_self/message-reply.html.twig', [
            'message' => $message,
            'parent' => $parent,
            'form' => $form,
        ]);
    }
    
    #[Route('/owner/request/{id}/reply', name: 'app_request_reply', methods: ['GET', 'POST'])]
    public function requestReply(Request $httpRequest, RequestRepository $requestRepository, \App\Entity\Request $request): Response
    {
        $form = $this->createForm(RequestOwnerReply::class, $request);
        $form->handleRequest($httpRequest);
        if ($form->isSubmitted() && $form->isValid()) {
            $requestRepository->save($request, true);
            return $this->redirectToRoute('owner_requests', [], Response::HTTP_SEE_OTHER);
        }
        $notes = $request->getNotes();

        return $this->renderForm('owner_self/request-reply.html.twig', [
            'request' => $request,
            'form' => $form,
            'notes' => $notes
        ]);
    }    
}
