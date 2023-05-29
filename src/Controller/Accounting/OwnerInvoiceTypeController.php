<?php

namespace App\Controller\Accounting;

use App\Entity\Accounting\OwnerInvoiceType;
use App\Form\Accounting\OwnerInvoiceTypeType;
use App\Repository\Accounting\OwnerInvoiceTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accounting/ownerInvoiceType')]
class OwnerInvoiceTypeController extends AbstractController
{
    #[Route('/', name: 'app_accounting_owner_invoice_type_index', methods: ['GET'])]
    public function index(OwnerInvoiceTypeRepository $ownerInvoiceTypeRepository): Response
    {
        return $this->render('accounting/owner_invoice_type/index.html.twig', [
            'owner_invoice_types' => $ownerInvoiceTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_accounting_owner_invoice_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OwnerInvoiceTypeRepository $ownerInvoiceTypeRepository): Response
    {
        $ownerInvoiceType = new OwnerInvoiceType();
        $form = $this->createForm(OwnerInvoiceTypeType::class, $ownerInvoiceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ownerInvoiceTypeRepository->save($ownerInvoiceType, true);

            return $this->redirectToRoute('app_accounting_owner_invoice_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/owner_invoice_type/new.html.twig', [
            'owner_invoice_type' => $ownerInvoiceType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accounting_owner_invoice_type_show', methods: ['GET'])]
    public function show(OwnerInvoiceType $ownerInvoiceType): Response
    {
        return $this->render('accounting/owner_invoice_type/show.html.twig', [
            'owner_invoice_type' => $ownerInvoiceType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_accounting_owner_invoice_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OwnerInvoiceType $ownerInvoiceType, OwnerInvoiceTypeRepository $ownerInvoiceTypeRepository): Response
    {
        $form = $this->createForm(OwnerInvoiceTypeType::class, $ownerInvoiceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ownerInvoiceTypeRepository->save($ownerInvoiceType, true);

            return $this->redirectToRoute('app_accounting_owner_invoice_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/owner_invoice_type/edit.html.twig', [
            'owner_invoice_type' => $ownerInvoiceType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accounting_owner_invoice_type_delete', methods: ['POST'])]
    public function delete(Request $request, OwnerInvoiceType $ownerInvoiceType, OwnerInvoiceTypeRepository $ownerInvoiceTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ownerInvoiceType->getId(), $request->request->get('_token'))) {
            $ownerInvoiceTypeRepository->remove($ownerInvoiceType, true);
        }

        return $this->redirectToRoute('app_accounting_owner_invoice_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
