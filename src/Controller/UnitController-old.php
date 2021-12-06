<?php

namespace App\Controller;

use App\Entity\Unit;
use App\Form\Unit1Type;
use App\Repository\UnitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/unit')]
class UnitController extends AbstractController
{
    #[Route('/', name: 'unit_index', methods: ['GET'])]
    public function index(Request $request, UnitRepository $unitRepository): Response
    {
		$buildingId = $request->query->get('buildingId');
		$search = $request->query->get('search');
		$query = ['buildingId' => $buildingId, 'search' => $search];
		if ($buildingId)
		{
			$units = $unitRepository->findAll($query);
		}
		else
		{
			$units = $unitRepository->findAll();
		}
        return $this->render('unit/index.html.twig', [
            'units' => $units,
        ]);
    }

    #[Route('/new', name: 'unit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $unit = new Unit();
        $form = $this->createForm(Unit1Type::class, $unit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($unit);
            $entityManager->flush();

            return $this->redirectToRoute('unit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('unit/new.html.twig', [
            'unit' => $unit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'unit_show', methods: ['GET'])]
    public function show(Unit $unit): Response
    {
        return $this->render('unit/show.html.twig', [
            'unit' => $unit,
        ]);
    }

    #[Route('/{id}/edit', name: 'unit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Unit $unit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Unit1Type::class, $unit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('unit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('unit/edit.html.twig', [
            'unit' => $unit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'unit_delete', methods: ['POST'])]
    public function delete(Request $request, Unit $unit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$unit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($unit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('unit_index', [], Response::HTTP_SEE_OTHER);
    }
}
