<?php

namespace App\Controller;

use App\Entity\Hoa;
use App\Form\HoaType;
use App\Repository\HoaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(('/admin/hoa'))]


class HoaController extends AbstractController
{
	#[Route('/', name: 'hoa_index', methods: ['GET'])]

    public function index(HoaRepository $hoaRepository): Response
    {
        return $this->render('hoa/index.html.twig', [
            'hoas' => $hoaRepository->findAll(),
        ]);
    }

	#[Route('/new', name: 'hoa_new', methods: ['GET', 'POST'])]

    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hoa = new Hoa();
        $form = $this->createForm(HoaType::class, $hoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hoa);
            $entityManager->flush();

            return $this->redirectToRoute('hoa_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hoa/new.html.twig', [
            'hoa' => $hoa,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'hoa_show', methods: ['GET'])]

    public function show(Hoa $hoa): Response
    {
        return $this->render('hoa/show.html.twig', [
            'hoa' => $hoa,
        ]);
    }
    #[Route('/{id}/edit', name: 'hoa_edit', methods: ['GET', 'POST'])]

    public function edit(Request $request, Hoa $hoa, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HoaType::class, $hoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('hoa_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hoa/edit.html.twig', [
            'hoa' => $hoa,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'hoa_delete', methods: ['POST'])]

    public function delete(Request $request, Hoa $hoa, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hoa->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hoa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hoa_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}/hoaAssignees', name: 'hoa_assignees', methods: ['GET', 'POST'])]

    public function assignees(Request $request, Hoa $hoa, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HoaType::class, $hoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('hoa_assignees', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hoa/assignees.html.twig', [
            'hoa' => $hoa,
            'form' => $form,
        ]);
    }    
}
