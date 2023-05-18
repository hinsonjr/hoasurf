<?php

namespace App\Controller\Accounting;

use App\Entity\Accounting\PaymentType;
use App\Form\Accounting\PaymentTypeType;
use App\Repository\Accounting\PaymentTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accounting/payment-type')]
class PaymentTypeController extends AbstractController
{
    #[Route('/', name: 'app_accounting_payment_type_index', methods: ['GET'])]
    public function index(PaymentTypeRepository $paymentTypeRepository): Response
    {
        return $this->render('accounting/payment_type/index.html.twig', [
            'payment_types' => $paymentTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_accounting_payment_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PaymentTypeRepository $paymentTypeRepository): Response
    {
        $paymentType = new PaymentType();
        $form = $this->createForm(PaymentTypeType::class, $paymentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paymentTypeRepository->save($paymentType, true);

            return $this->redirectToRoute('app_accounting_payment_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/payment_type/new.html.twig', [
            'payment_type' => $paymentType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accounting_payment_type_show', methods: ['GET'])]
    public function show(PaymentType $paymentType): Response
    {
        return $this->render('accounting/payment_type/show.html.twig', [
            'payment_type' => $paymentType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_accounting_payment_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PaymentType $paymentType, PaymentTypeRepository $paymentTypeRepository): Response
    {
        $form = $this->createForm(PaymentTypeType::class, $paymentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paymentTypeRepository->save($paymentType, true);

            return $this->redirectToRoute('app_accounting_payment_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/payment_type/edit.html.twig', [
            'payment_type' => $paymentType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accounting_payment_type_delete', methods: ['POST'])]
    public function delete(Request $request, PaymentType $paymentType, PaymentTypeRepository $paymentTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paymentType->getId(), $request->request->get('_token'))) {
            $paymentTypeRepository->remove($paymentType, true);
        }

        return $this->redirectToRoute('app_accounting_payment_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
