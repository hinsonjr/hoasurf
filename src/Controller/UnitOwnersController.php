<?php

namespace App\Controller;

use App\Entity\UnitOwners;
use App\Form\UnitOwnersType;
use App\Repository\UnitOwnersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/owner/units')]
class UnitOwnersController extends AbstractController
{
    #[Route('/', name: 'app_owner_units_index', methods: ['GET'])]
    public function index(UnitOwnersRepository $unitOwnersRepository): Response
    {
        return $this->render('owner_units/index.html.twig', [
            'owner_units' => $unitOwnersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_owner_units_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UnitOwnersRepository $unitOwnersRepository): Response
    {
        $ownerUnit = new UnitOwners();
        $form = $this->createForm(UnitOwnersType::class, $ownerUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $unitOwnersRepository->save($ownerUnit, true);

            return $this->redirectToRoute('app_owner_units_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('owner_units/new.html.twig', [
            'owner_unit' => $ownerUnit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_owner_units_show', methods: ['GET'])]
    public function show(UnitOwners $ownerUnit): Response
    {
        return $this->render('owner_units/show.html.twig', [
            'owner_unit' => $ownerUnit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_owner_units_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UnitOwners $ownerUnit, UnitOwnersRepository $unitOwnersRepository): Response
    {
        $form = $this->createForm(UnitOwnersType::class, $ownerUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $unitOwnersRepository->save($ownerUnit, true);

            return $this->redirectToRoute('app_owner_units_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('owner_units/edit.html.twig', [
            'owner_unit' => $ownerUnit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_owner_units_delete', methods: ['POST'])]
    public function delete(Request $request, UnitOwners $ownerUnit, UnitOwnersRepository $unitOwnersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ownerUnit->getId(), $request->request->get('_token'))) {
            $unitOwnersRepository->remove($ownerUnit, true);
        }

        return $this->redirectToRoute('app_owner_units_index', [], Response::HTTP_SEE_OTHER);
    }
}
