<?php

namespace App\Controller;

use App\Entity\Owner;
use App\Form\OwnerType;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/owner')]
class OwnerController extends AbstractController
{
    #[Route('/', name: 'owner_index', methods: ['GET'])]
    public function index(Request $request, OwnerRepository $ownerRepository): Response
    {
		$search = $request->query->get('search');
		$query = ['search' => $search];
		if ($search)
		{
			$query = ['search' => $search];
			$owners = $ownerRepository->findAll($query);
		}
		else
		{
			$owners = $ownerRepository->findAll();
		}
        return $this->render('owner/index.html.twig', [
            'owners' => $owners,
        ]);		
    }
	
	public function getOwners(Request $request, $data)
	{
	    $json = array();
	    if ($request->isXmlHttpRequest()) {		
			if (array_key_exists('search',$data))
			{
				$query = ['search' => $search];
				$owners = $ownerRepository->findAll($query);
			}
			$owners = $ownerRepository->findAll();
		}
		return new JsonResponse($json);
	}

    #[Route('/new', name: 'owner_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $owner = new Owner();
        $form = $this->createForm(OwnerType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($owner);
            $entityManager->flush();

            return $this->redirectToRoute('owner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('owner/new.html.twig', [
            'owner' => $owner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'owner_show', methods: ['GET'])]
    public function show(Owner $owner): Response
    {
        return $this->render('owner/show.html.twig', [
            'owner' => $owner,
        ]);
    }

    #[Route('/{id}/edit', name: 'owner_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Owner $owner, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OwnerType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('owner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('owner/edit.html.twig', [
            'owner' => $owner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'owner_delete', methods: ['POST'])]
    public function delete(Request $request, Owner $owner, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$owner->getId(), $request->request->get('_token'))) {
            $entityManager->remove($owner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('owner_index', [], Response::HTTP_SEE_OTHER);
    }
}
