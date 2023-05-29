<?php

namespace App\Controller;

use App\Entity\UnitOwner;
use App\Form\UnitOwnerType;
use App\Repository\UnitOwnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/owner/units')]
class UnitOwnerController extends AbstractController
{
    #[Route('/', name: 'app_owner_units_index', methods: ['GET'])]
    public function index(UnitOwnerRepository $unitOwnerRepository): Response
    {
        return $this->render('owner_units/index.html.twig', [
            'owner_units' => $unitOwnerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_owner_units_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UnitOwnerRepository $unitOwnerRepository): Response
    {
        $ownerUnit = new UnitOwner();
        $form = $this->createForm(UnitOwnerType::class, $ownerUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $unitOwnerRepository->save($ownerUnit, true);

            return $this->redirectToRoute('app_owner_units_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('owner_units/new.html.twig', [
            'owner_unit' => $ownerUnit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_owner_units_show', methods: ['GET'])]
    public function show(UnitOwner $ownerUnit): Response
    {
        return $this->render('owner_units/show.html.twig', [
            'owner_unit' => $ownerUnit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_owner_units_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UnitOwner $ownerUnit, UnitOwnerRepository $unitOwnerRepository): Response
    {
        $form = $this->createForm(UnitOwnerType::class, $ownerUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $unitOwnerRepository->save($ownerUnit, true);

            return $this->redirectToRoute('app_owner_units_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('owner_units/edit.html.twig', [
            'owner_unit' => $ownerUnit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_owner_units_delete', methods: ['POST'])]
    public function delete(Request $request, UnitOwner $ownerUnit, UnitOwnerRepository $unitOwnerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ownerUnit->getId(), $request->request->get('_token'))) {
            $unitOwnerRepository->remove($ownerUnit, true);
        }

        return $this->redirectToRoute('app_owner_units_index', [], Response::HTTP_SEE_OTHER);
    }
}
