<?php

namespace App\Controller\Accounting;

use App\Entity\Accounting\LedgerAccount;
use App\Form\Accounting\LedgerAccountType;
use App\Repository\Accounting\LedgerAccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/accounting/ledger-account')]
class LedgerAccountController extends AbstractController
{
    #[Route('/', name: 'accounting_ledger_account_index', methods: ['GET'])]
    public function index(LedgerAccountRepository $ledgerAccountRepository): Response
    {
        return $this->render('accounting/ledger_account/index.html.twig', [
            'ledger_accounts' => $ledgerAccountRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'accounting_ledger_account_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ledgerAccount = new LedgerAccount();
        $form = $this->createForm(LedgerAccountType::class, $ledgerAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ledgerAccount);
            $entityManager->flush();

            return $this->redirectToRoute('accounting_ledger_account_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/ledger_account/new.html.twig', [
            'ledger_account' => $ledgerAccount,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'accounting_ledger_account_show', methods: ['GET'])]
    public function show(LedgerAccount $ledgerAccount, EntityManagerInterface $entityManager): Response
    {
		$transactions = $entityManager->getRepository(\app\Entity\Accounting\Transaction::class)->findByLedgerAccount($ledgerAccount->getId());
		
        return $this->render('accounting/ledger_account/show.html.twig', [
            'ledger_account' => $ledgerAccount,
			'transactions' => $transactions
        ]);
    }

    #[Route('/{id}/edit', name: 'accounting_ledger_account_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LedgerAccount $ledgerAccount, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LedgerAccountType::class, $ledgerAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('accounting_ledger_account_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/ledger_account/edit.html.twig', [
            'ledger_account' => $ledgerAccount,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'accounting_ledger_account_delete', methods: ['POST'])]
    public function delete(Request $request, LedgerAccount $ledgerAccount, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ledgerAccount->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ledgerAccount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('accounting_ledger_account_index', [], Response::HTTP_SEE_OTHER);
    }
}
