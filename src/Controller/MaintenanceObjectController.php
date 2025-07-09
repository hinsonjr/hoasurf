<?php

namespace App\Controller;

use App\Entity\MaintenanceObject;
use App\Form\MaintenanceObject1Type;
use App\Repository\MaintenanceObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/maintenance/object')]
class MaintenanceObjectController extends AbstractController
{
    #[Route('/', name: 'maintenance_object_index', methods: ['GET'])]
    public function index(MaintenanceObjectRepository $maintenanceObjectRepository): Response
    {
        return $this->render('maintenance_object/index.html.twig', [
            'maintenance_objects' => $maintenanceObjectRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'maintenance_object_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $maintenanceObject = new MaintenanceObject();
        $form = $this->createForm(MaintenanceObject1Type::class, $maintenanceObject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($maintenanceObject);
            $entityManager->flush();

            return $this->redirectToRoute('maintenance_object_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('maintenance_object/new.html.twig', [
            'maintenance_object' => $maintenanceObject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'maintenance_object_show', methods: ['GET'])]
    public function show(MaintenanceObject $maintenanceObject): Response
    {
        return $this->render('maintenance_object/show.html.twig', [
            'maintenance_object' => $maintenanceObject,
        ]);
    }

    #[Route('/{id}/edit', name: 'maintenance_object_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MaintenanceObject $maintenanceObject, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MaintenanceObject1Type::class, $maintenanceObject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('maintenance_object_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('maintenance_object/edit.html.twig', [
            'maintenance_object' => $maintenanceObject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'maintenance_object_delete', methods: ['POST'])]
    public function delete(Request $request, MaintenanceObject $maintenanceObject, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maintenanceObject->getId(), $request->request->get('_token'))) {
            $entityManager->remove($maintenanceObject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('maintenance_object_index', [], Response::HTTP_SEE_OTHER);
    }
}
