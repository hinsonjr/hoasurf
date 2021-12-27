<?php

namespace App\Controller\Accounting;

use App\Entity\Accounting\Transaction;
use App\Form\Accounting\TransactionType;
use App\Repository\Accounting\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accounting/transaction')]
class TransactionController extends AbstractController
{
    #[Route('/', name: 'accounting_transaction_index', methods: ['GET'])]
    public function index(TransactionRepository $transactionRepository): Response
    {
        return $this->render('accounting/transaction/index.html.twig', [
            'transactions' => $transactionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'accounting_transaction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			$debitAcct = $transaction->getDebitAccount();
			$debitAcct = $debitAcct->getType()->getIsDebit() ? 
				$debitAcct->setBalance($debitAcct->getBalance() + $transaction->getAmount()) : 
				$debitAcct->setBalance($debitAcct->getBalance() - $transaction->getAmount());
			$creditAcct = $transaction->getCreditAccount();
			$creditAcct = $creditAcct->getType()->getIsDebit() ? 
				$creditAcct->setBalance($creditAcct->getBalance() - $transaction->getAmount()) : 
				$creditAcct->setBalance($creditAcct->getBalance() + $transaction->getAmount());
            $entityManager->persist($transaction);
            $entityManager->persist($transaction->getDebitAccount());
            $entityManager->persist($transaction->getCreditAccount());
            $entityManager->flush();

            return $this->redirectToRoute('accounting_transaction_index', [], Response::HTTP_SEE_OTHER);
        }
		$date = new \DateTime();
		$transaction->setDate($date);
        return $this->renderForm('accounting/transaction/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'accounting_transaction_show', methods: ['GET'])]
    public function show(Transaction $transaction): Response
    {
        return $this->render('accounting/transaction/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    #[Route('/{id}/edit', name: 'accounting_transaction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('accounting_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'accounting_transaction_delete', methods: ['POST'])]
    public function delete(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getId(), $request->request->get('_token'))) {
            $entityManager->remove($transaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('accounting_transaction_index', [], Response::HTTP_SEE_OTHER);
    }
}
