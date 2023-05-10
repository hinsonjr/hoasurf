<?php

namespace App\Controller;

use App\Entity\Unit;
use App\Form\Unit2Type;
use App\Form\UnitChangeOwnerType;
use App\Repository\UnitRepository;
use App\Repository\OwnerRepository;
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
	private $units = [];
    #[Route('/', name: 'unit_index', methods: ['GET'])]
    public function index(Request $request, OwnerRepository $ownerRepository, UnitRepository $unitRepository, BuildingRepository $buildingRepository): Response
    {
		$query['buildingId'] = $request->query->get('buildingId');
		$query['unitSearch'] = $request->query->get('unitSearch');
		$query['ownerSearch'] = $request->query->get('ownerSearch');
		if ($query['buildingId'] || $query['unitSearch'])
		{
			$this->units = $unitRepository->findAll($query);
		}
		if ($query['ownerSearch'])
		{
			$owners = $ownerRepository->findAll($query);
			foreach ($owners as $owner)
			{
				foreach ($owner->getOwnerUnits() as $ownerUnits)
				{
					$this->units[] = $ownerUnits->getUnit();
				}
			}
		}
		if (!$query['buildingId'] && !$query['unitSearch'] && !$query['ownerSearch'])
		{
			$this->units = $unitRepository->findAll();
		}

//		foreach ($units as $key => $unit)
//		{
//			$owners = $unit->getOwnerUnits();
////			Debug::dump($owners);
//		}
        return $this->render('unit/index.html.twig', [
            'units' => $this->units,
            'buildings' => $buildingRepository->findAll(),
			'query' => $query
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
        $form = $this->createForm(UnitChangeOwnerType::class, $unit);
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

        return $this->renderForm('unit/change_owner.html.twig', [
            'unit' => $unit,
            'form' => $form,
        ]);
    }	
}
