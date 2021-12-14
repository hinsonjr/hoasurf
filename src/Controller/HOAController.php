<?php

namespace App\Controller;

use App\Entity\HOA;
use App\Form\HOAType;
use App\Repository\HOARepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/hoa')]
class HOAController extends AbstractController
{
    #[Route('/', name: 'hoa_index', methods: ['GET'])]
    public function index(HOARepository $hOARepository): Response
    {
        return $this->render('hoa/index.html.twig', [
            'hoas' => $hOARepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'hoa_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hOA = new HOA();
        $form = $this->createForm(HOAType::class, $hOA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hOA);
            $entityManager->flush();

            return $this->redirectToRoute('hoa_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hoa/new.html.twig', [
            'hoa' => $hOA,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'hoa_show', methods: ['GET'])]
    public function show(HOA $hOA, HOARepository $hOARepository): Response
    {
		$owners = $hOARepository->findHoaUnitOwners($hOA);
        return $this->render('hoa/show.html.twig', [
            'hoa' => $hOA,
			'owners' => $owners
        ]);
    }

    #[Route('/{id}/edit', name: 'hoa_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HOA $hOA, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HOAType::class, $hOA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('hoa_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hoa/edit.html.twig', [
            'hoa' => $hOA,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'hoa_delete', methods: ['POST'])]
    public function delete(Request $request, HOA $hOA, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hOA->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hOA);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hoa_index', [], Response::HTTP_SEE_OTHER);
    }
}
