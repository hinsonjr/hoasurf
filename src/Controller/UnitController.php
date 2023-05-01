<?php

namespace App\Controller;

use App\Entity\Unit;
use App\Form\Unit2Type;
use App\Repository\UnitRepository;
use App\Repository\BuildingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Util\Debug;

#[Route('/admin/unit')]
class UnitController extends AbstractController
{
    #[Route('/', name: 'unit_index', methods: ['GET'])]
    public function index(Request $request, UnitRepository $unitRepository, BuildingRepository $buildingRepository): Response
    {
		$buildingId = $request->query->get('buildingId');
		$search = $request->query->get('search');
		$query = ['buildingId' => $buildingId, 'search' => $search];
		if ($buildingId || $search)
		{
			$units = $unitRepository->findAll($query);
		}
		else
		{
			$units = $unitRepository->findAll();
		}
		foreach ($units as $key => $unit)
		{
			$owners = $unit->getOwners();
//			Debug::dump($owners);
		}
        return $this->render('unit/index.html.twig', [
            'units' => $units,
			'buildingId' => $buildingId,
            'buildings' => $buildingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'unit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $unit = new Unit();
        $form = $this->createForm(Unit2Type::class, $unit);
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
        $form = $this->createForm(Unit2Type::class, $unit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//			if ($this->validateUnit($form))
//			{
				$entityManager->flush();

				return $this->redirectToRoute('unit_index', [], Response::HTTP_SEE_OTHER);
//			}
//			else
//			{
//				// Handle unit / owner assignmeent?
//			}
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
	

    #[Route('/{id}/change-owner', name: 'unit_change_owner', methods: ['GET', 'POST'])]
    public function changeOwner(Request $request, Unit $unit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UnitChangeOwner::class, $unit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//			if ($this->validateUnit($form))
//			{
				$entityManager->flush();

				return $this->redirectToRoute('unit_index', [], Response::HTTP_SEE_OTHER);
//			}
//			else
//			{
//				// Handle unit / owner assignmeent?
//			}
        }

        return $this->renderForm('unit/edit.html.twig', [
            'unit' => $unit,
            'form' => $form,
        ]);
    }	
}
