<?php

namespace App\Controller\Accounting;

use App\Entity\Accounting\OwnerInvoice;
use App\Form\Accounting\OwnerInvoiceType;
use App\Form\Accounting\OwnerInvoiceSetType;
use App\Entity\Accounting\Transaction;
use App\Repository\Accounting\OwnerInvoiceRepository;
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
	public function __construct(private EntityManagerInterface $entityManager) {}
	 
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

        if ($form->isSubmitted() && $form->isValid()) {
            $ownerInvoiceRepo->save($ownerInvoice, true);

            return $this->redirectToRoute('app_accounting_owner_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/owner_invoice/new.html.twig', [
            'owner_invoice' => $ownerInvoice,
            'form' => $form,
        ]);
    }

	
    #[Route('/newSet', name: 'app_accounting_owner_invoice_new_set', methods: ['GET', 'POST'])]
    public function newSet(Request $request, 
			OwnerInvoiceRepository $ownerInvoiceRepo,LedgerAccountRepository $ledgerAcctRepo, 
			HoaRepository $hoaRepo): Response
    {
        $ownerInvoice = new OwnerInvoice();
        $form = $this->createForm(OwnerInvoiceSetType::class, $ownerInvoice);
		$form->remove('transaction.date');
        $form->handleRequest($request);

		$currentOwners = [];
		$effectiveDate =  $form->get('effectiveDate')->getData();
        if ($form->isSubmitted() ) {
			$hoa = $ownerInvoice->getHoa();
//			$units = $hoaRepo->getCurrentOwners();
			$currentOwners = $hoaRepo->findOwnerByEffectiveDate($hoa,$effectiveDate);
//			foreach ($units as $unit)
//			{
//				$ownerUnits = $unit->findOwnerUnits();
//				foreach ($ownerUnits as $ownerUnit)
//				{
//					if (($ownerUnit->getEndDate() == null || $ownerUnit->getEndDate() > $effectiveDate)
//						&& $ownerUnit->getStartDate() > $effectiveDate)
//					{
//						$currentOwners[$unit->getUnitId()] = $ownerUnit->getOwner();
//					}
//				}
//			}
			$ownerPercents = [];
			$ownerEmails = [];
			foreach ($currentOwners as $ownerUnit)
			{
				$unitId = $ownerUnit->getUnit()->getId();
				if (array_key_exists($unitId,$ownerPercents))
				{
					$percent = $ownerUnit->getOwnPercent();
					if (($percent + $ownerPercents[$unitId]) < 100)
					{
						$ownerPercents[$unitId] = $ownerUnit->getOwnPercent();
					}
					else
					{
						echo "This unit $unitId already has 100% ownership<br>";
					}
					echo "<p>Owner of unit " . $unitId . " =>" . $ownerUnit->getOwner()->getName(). "</p>";
				}
				else
				{
					$ownerPercents[$unitId] = $ownerUnit->getOwnPercent();
				}
			}
			$debitAccount = $ledgerAcctRepo->findOneByName("Owner Payments");
			$creditAccount = $ledgerAcctRepo->findOneByName("Owner Receivables");
			
			foreach ($hoaRepo->findUnits($hoa) as $unit)
			{
				$unitId = $unit->getId();
				if (array_key_exists($unitId,$ownerPercents) && $ownerPercents[$unitId] >= 99)
				{
					echo "Unit $unitId has 100% ownership<br>";
					$transaction = New \App\Entity\Accounting\Transaction($debitAccount, $creditAccount);
					$transaction->setAmount($form['amount']->getData());
					$this->entityManager->persist($transaction);
					$this->entityManager->flush($transaction);
				}
				else
				{
					echo "Unit $unitId does not have 100% ownership<br>";
				}
			}
			die("FRED");
            return $this->redirectToRoute('app_accounting_owner_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/owner_invoice/new.html.twig', [
            'owner_invoice' => $ownerInvoice,
            'form' => $form,
        ]);
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

        if ($form->isSubmitted() && $form->isValid()) {
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
        if ($this->isCsrfTokenValid('delete'.$ownerInvoice->getId(), $request->request->get('_token'))) {
            $ownerInvoiceRepo->remove($ownerInvoice, true);
        }

        return $this->redirectToRoute('app_accounting_owner_invoice_index', [], Response::HTTP_SEE_OTHER);
    }
}
