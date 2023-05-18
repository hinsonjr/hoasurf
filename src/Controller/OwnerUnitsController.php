<?php

namespace App\Controller;

use App\Entity\OwnerUnits;
use App\Form\OwnerUnitsType;
use App\Repository\OwnerUnitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/owner/units')]
class OwnerUnitsController extends AbstractController
{
    #[Route('/', name: 'app_owner_units_index', methods: ['GET'])]
    public function index(OwnerUnitsRepository $ownerUnitsRepository): Response
    {
        return $this->render('owner_units/index.html.twig', [
            'owner_units' => $ownerUnitsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_owner_units_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OwnerUnitsRepository $ownerUnitsRepository): Response
    {
        $ownerUnit = new OwnerUnits();
        $form = $this->createForm(OwnerUnitsType::class, $ownerUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ownerUnitsRepository->save($ownerUnit, true);

            return $this->redirectToRoute('app_owner_units_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('owner_units/new.html.twig', [
            'owner_unit' => $ownerUnit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_owner_units_show', methods: ['GET'])]
    public function show(OwnerUnits $ownerUnit): Response
    {
        return $this->render('owner_units/show.html.twig', [
            'owner_unit' => $ownerUnit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_owner_units_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OwnerUnits $ownerUnit, OwnerUnitsRepository $ownerUnitsRepository): Response
    {
        $form = $this->createForm(OwnerUnitsType::class, $ownerUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ownerUnitsRepository->save($ownerUnit, true);

            return $this->redirectToRoute('app_owner_units_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('owner_units/edit.html.twig', [
            'owner_unit' => $ownerUnit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_owner_units_delete', methods: ['POST'])]
    public function delete(Request $request, OwnerUnits $ownerUnit, OwnerUnitsRepository $ownerUnitsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ownerUnit->getId(), $request->request->get('_token'))) {
            $ownerUnitsRepository->remove($ownerUnit, true);
        }

        return $this->redirectToRoute('app_owner_units_index', [], Response::HTTP_SEE_OTHER);
    }
}
