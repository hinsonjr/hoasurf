<?php

namespace App\Controller;

use App\Entity\Building;
use App\Form\Building1Type;
use App\Repository\BuildingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/building')]
class BuildingController extends AbstractController
{
    #[Route('/', name: 'building_index', methods: ['GET'])]
    public function index(BuildingRepository $buildingRepository): Response
    {
        return $this->render('building/index.html.twig', [
            'buildings' => $buildingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'building_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $building = new Building();
        $form = $this->createForm(Building1Type::class, $building);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($building);
            $entityManager->flush();

            return $this->redirectToRoute('building_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('building/new.html.twig', [
            'building' => $building,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'building_show', methods: ['GET'])]
    public function show(Building $building): Response
    {
        return $this->render('building/show.html.twig', [
            'building' => $building,
        ]);
    }

    #[Route('/{id}/edit', name: 'building_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Building $building, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Building1Type::class, $building);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('building_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('building/edit.html.twig', [
            'building' => $building,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'building_delete', methods: ['POST'])]
    public function delete(Request $request, Building $building, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$building->getId(), $request->request->get('_token'))) {
            $entityManager->remove($building);
            $entityManager->flush();
        }

        return $this->redirectToRoute('building_index', [], Response::HTTP_SEE_OTHER);
    }
}
