<?php

namespace App\Controller\Accounting;

use App\Entity\Accounting\LedgerType;
use App\Form\Accounting\LedgerTypeType;
use App\Repository\Accounting\LedgerTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accounting/ledger/type')]
class LedgerTypeController extends AbstractController
{
    #[Route('/', name: 'accounting_ledger_type_index', methods: ['GET'])]
    public function index(LedgerTypeRepository $ledgerTypeRepository): Response
    {
        return $this->render('accounting/ledger_type/index.html.twig', [
            'ledger_types' => $ledgerTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'accounting_ledger_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ledgerType = new LedgerType();
        $form = $this->createForm(LedgerTypeType::class, $ledgerType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ledgerType);
            $entityManager->flush();

            return $this->redirectToRoute('accounting_ledger_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/ledger_type/new.html.twig', [
            'ledger_type' => $ledgerType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'accounting_ledger_type_show', methods: ['GET'])]
    public function show(LedgerType $ledgerType): Response
    {
        return $this->render('accounting/ledger_type/show.html.twig', [
            'ledger_type' => $ledgerType,
        ]);
    }

    #[Route('/{id}/edit', name: 'accounting_ledger_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LedgerType $ledgerType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LedgerTypeType::class, $ledgerType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('accounting_ledger_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/ledger_type/edit.html.twig', [
            'ledger_type' => $ledgerType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'accounting_ledger_type_delete', methods: ['POST'])]
    public function delete(Request $request, LedgerType $ledgerType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ledgerType->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ledgerType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('accounting_ledger_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
