<?php

namespace App\Controller\Accounting;

use App\Entity\Accounting\OwnerInvoice;
use App\Form\Accounting\OwnerInvoiceType;
use App\Form\Accounting\OwnerInvoiceAssessmentType;
use App\Form\Accounting\OwnerInvoiceDuesType;
use App\Entity\Accounting\Transaction;
use App\Repository\Accounting\OwnerInvoiceRepository;
use App\Repository\Accounting\OwnerInvoiceTypeRepository;
use App\Repository\Accounting\LedgerAccountRepository;
use App\Repository\HoaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/accounting/ownerInvoice')]
class OwnerInvoiceController extends AbstractController
{

	private $debitAccount;
	private $creditAccount;
	public function __construct(private EntityManagerInterface $entityManager)
	{
		
	}

	#[Route('/', name: 'app_accounting_owner_invoice_index', methods: ['GET'])]
	public function index(OwnerInvoiceRepository $ownerInvoiceRepo): Response
	{
		return $this->render('accounting/owner_invoice/index.html.twig', [
				'owner_invoices' => $ownerInvoiceRepo->findAll(),
		]);
	}

	#[Route('/new', name: 'app_accounting_owner_invoice_new', methods: ['GET', 'POST'])]
	public function new(Request $request, OwnerInvoiceRepository $ownerInvoiceRepo): Response
	{
		$ownerInvoice = new OwnerInvoice();
		$form = $this->createForm(OwnerInvoiceType::class, $ownerInvoice);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			$ownerInvoiceRepo->save($ownerInvoice, true);

			return $this->redirectToRoute('app_accounting_owner_invoice_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('accounting/owner_invoice/new.html.twig', [
				'owner_invoice' => $ownerInvoice,
				'form' => $form,
		]);
	}

	#[Route('/newAssessment', name: 'app_accounting_owner_invoice_assessments', methods: ['GET', 'POST'])]
	public function newAssessment(Request $request,
		OwnerInvoiceRepository $ownerInvoiceRepo, LedgerAccountRepository $ledgerAcctRepo, OwnerInvoiceTypeRepository $ownerInvoiceTypeRepo,
		HoaRepository $hoaRepo): Response
	{
		$ownerInvoice = new OwnerInvoice();
		$form = $this->createForm(OwnerInvoiceAssessmentType::class, $ownerInvoice);
		$form->remove('transaction.date');
		$form->handleRequest($request);
		$type = $ownerInvoiceTypeRepo->findOneByType("Assessment");
		$currentOwners = [];
		$postDate = $form->get('postDate')->getData();
		if ($form->isSubmitted())
		{
			$hoa = $ownerInvoice->getHoa();
			$currentOwners = $hoaRepo->findUnitOwnerByPostDate($hoa, $postDate);
			$ownerPercents = [];
			$ownerEmails = [];
			foreach ($currentOwners as $unitOwner)
			{
				$unitId = $unitOwner->getUnit()->getId();
				if (array_key_exists($unitId, $ownerPercents))
				{
					$percent = $unitOwner->getOwnPercent();
					if (($percent + $ownerPercents[$unitId]) < 100)
					{
						$ownerPercents[$unitId] = $unitOwner->getOwnPercent();
					} else
					{
						echo "<p>This unit $unitId already has 100% ownership so only first owner(s) will be billed.<br>"
							. " Owner " . $unitOwner->getOwner()->getName() . "will not be billed</p>";
					}
				} else
				{
					$ownerPercents[$unitId] = $unitOwner->getOwnPercent();
				}
			}
			$this->debitAccount = $ledgerAcctRepo->findOneByName("Owner Assessments");
			$this->creditAccount = $ledgerAcctRepo->findOneByName("Owner Receivables");

			foreach ($hoaRepo->findUnits($hoa) as $unit)
			{
				$unitId = $unit->getId();
				if (array_key_exists($unitId, $ownerPercents) && $ownerPercents[$unitId] >= 99)
				{
					foreach ($unit->getUnitOwner() as $unitOwner)
					{
						$this->commitOwnerInvoice($ownerInvoice, $unitOwner, $form, $type);
					}
				} else
				{
					echo "Unit $unitId does not have 100% ownership<br>";
				}
			}
			return $this->redirectToRoute('app_accounting_owner_invoice_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('accounting/owner_invoice/new_assessment.html.twig', [
				'owner_invoice' => $ownerInvoice,
				'form' => $form,
		]);
	}

	#[Route('/newDues', name: 'app_accounting_owner_invoice_dues', methods: ['GET', 'POST'])]
	public function newDues(Request $request,
		OwnerInvoiceRepository $ownerInvoiceRepo, LedgerAccountRepository $ledgerAcctRepo,
		HoaRepository $hoaRepo): Response
	{
		$ownerInvoice = new OwnerInvoice();
		$form = $this->createForm(OwnerInvoiceType::class, $ownerInvoice);
		$form->remove('transaction.date');
		$form->handleRequest($request);

		$currentOwners = [];
		$postDate = $form->get('postDate')->getData();
		if ($form->isSubmitted())
		{
			$hoa = $ownerInvoice->getHoa();
			$currentOwners = $hoaRepo->findUnitOwnerByPostDate($hoa, $postDate);
			$ownerPercents = [];
			$ownerEmails = [];
			foreach ($currentOwners as $unitOwner)
			{
				$unitId = $unitOwner->getUnit()->getId();
				if (array_key_exists($unitId, $ownerPercents))
				{
					$percent = $unitOwner->getOwnPercent();
					if (($percent + $ownerPercents[$unitId]) < 100)
					{
						$ownerPercents[$unitId] = $unitOwner->getOwnPercent();
					} else
					{
						echo "<p>This unit $unitId already has 100% ownership so only first owner(s) will be billed.<br>"
							. " Owner " . $unitOwner->getOwner()->getName() . "will not be billed</p>";
//						echo "Owner of unit " . $unitId . " =>" . $unitOwner->getOwner()->getName() . "</p>"
					}
//					echo "<p>Owner of unit " . $unitId . " =>" . $unitOwner->getOwner()->getName() . "</p>";
				} else
				{
					$ownerPercents[$unitId] = $unitOwner->getOwnPercent();
				}
			}
			$this->debitAccount = $ledgerAcctRepo->findOneByName("Owner Payments");
			$this->creditAccount = $ledgerAcctRepo->findOneByName("Owner Receivables");

			foreach ($hoaRepo->findUnits($hoa) as $unit)
			{
				$unitId = $unit->getId();
				if (array_key_exists($unitId, $ownerPercents) && $ownerPercents[$unitId] >= 99)
				{
					foreach ($unit->getUnitOwner() as $unitOwner)
					{
						$this->postTransaction($ownerInvoice, $unitOwner, $form);
					}
				} else
				{
					echo "Unit $unitId does not have 100% ownership<br>";
				}
			}
			return $this->redirectToRoute('app_accounting_owner_invoice_index', [], Response::HTTP_SEE_OTHER);
		}
		return $this->renderForm('accounting/owner_invoice/new_dues.html.twig', [
				'owner_invoice' => $ownerInvoice,
				'form' => $form,
		]);
	}

	private function postTransaction($ownerInvoice, $unitOwner, $form)
	{
		$transaction = New \App\Entity\Accounting\Transaction($this->debitAccount, $this->creditAccount);
		$transaction->setAmount($form['amount']->getData());
		$transaction->setDate($form['postDate']->getData());
		$this->entityManager->persist($transaction);
		$this->entityManager->flush();
		return $transaction;
	}
	
	public function checkUncommittedOwnerInvoices(OwnerInvoiceRepository $ownerInvoiceRepo)
	{
		$uncommitted = $ownerInvoiceRepo->findUncommitted();
		foreach ($uncommitted as $ownerInvoice)
		{
			
		}
	}

	private function commitOwnerInvoice($ownerInvoice, $unitOwner, $form, $type)
	{
		$now = new \DateTime();
		$unitId = $unitOwner->getUnit()->getId();
		echo "Unit $unitId has 100% ownership<br>";
		$newOwnerInvoice = clone($ownerInvoice);
		if ($ownerInvoice->getPostDate() <= $now)
		{
			$transaction = $this->postTransaction($ownerInvoice, $unitOwner, $form);
			$newOwnerInvoice->setTransaction($transaction);
		}
		$newOwnerInvoice->setType($type);
		$newOwnerInvoice->setUnitOwner($unitOwner);
		$this->entityManager->persist($newOwnerInvoice);
		$this->entityManager->flush();
	}

	#[Route('/{id}', name: 'app_accounting_owner_invoice_show', methods: ['GET'])]
	public function show(OwnerInvoice $ownerInvoice): Response
	{
		return $this->render('accounting/owner_invoice/show.html.twig', [
				'owner_invoice' => $ownerInvoice,
		]);
	}

	#[Route('/{id}/edit', name: 'app_accounting_owner_invoice_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, OwnerInvoice $ownerInvoice, OwnerInvoiceRepository $ownerInvoiceRepo): Response
	{
		$form = $this->createForm(OwnerInvoiceType::class, $ownerInvoice);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			$ownerInvoiceRepo->save($ownerInvoice, true);

			return $this->redirectToRoute('app_accounting_owner_invoice_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('accounting/owner_invoice/edit.html.twig', [
				'owner_invoice' => $ownerInvoice,
				'form' => $form,
		]);
	}

	#[Route('/{id}', name: 'app_accounting_owner_invoice_delete', methods: ['POST'])]
	public function delete(Request $request, OwnerInvoice $ownerInvoice, OwnerInvoiceRepository $ownerInvoiceRepo): Response
	{
		if ($this->isCsrfTokenValid('delete' . $ownerInvoice->getId(), $request->request->get('_token')))
		{
			$ownerInvoiceRepo->remove($ownerInvoice, true);
		}

		return $this->redirectToRoute('app_accounting_owner_invoice_index', [], Response::HTTP_SEE_OTHER);
	}

}
