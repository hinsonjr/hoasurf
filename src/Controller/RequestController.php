<?php

namespace App\Controller;

use App\Entity\Request;
use App\Entity\RequestNote;
use App\Form\Request1Type;
use App\Repository\RequestRepository;
use App\Repository\RequestTypeRepository;
use App\Repository\RequestStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin/request')]
class RequestController extends AbstractController
{
	public function __construct(private EntityManagerInterface $entityManager)
	{
		
	}
    
    #[Route('/', name: 'app_request_index', methods: ['GET'])]
    public function index(HttpRequest $request, RequestRepository $requestRepository, RequestTypeRepository $typeRepo, RequestStatusRepository $statusRepo): Response
    {
		$types = $typeRepo->findAll();
		$statuses = $statusRepo->findAll();
		$filters['type'] = $request->get("type");
		$filters['status'] = $request->get("status");
        return $this->render('request/index.html.twig', [
            'requests' => $requestRepository->findByFilters($filters),
			'typeList' => $types,
			'statusList' => $statuses,
			'filters' => $filters
        ]);
    }

    #[Route('/new', name: 'app_request_new', methods: ['GET', 'POST'])]
    public function new(HttpRequest $httpRequest, RequestRepository $requestRepository): Response
    {
        $request = new Request();
        $form = $this->createForm(Request1Type::class, $request);
        $form->handleRequest($httpRequest);

        if ($form->isSubmitted() && $form->isValid()) {
            $requestRepository->save($request, true);

            return $this->redirectToRoute('app_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('request/new.html.twig', [
            'request' => $request,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_request_show', methods: ['GET'])]
    public function show(HttpRequest $httpRequest, Request $request): Response
    {
        return $this->render('request/show.html.twig', [
            'request' => $request,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_request_edit', methods: ['GET', 'POST'])]
    public function edit(HttpRequest $httpRequest, Request $request, RequestRepository $requestRepository): Response
    {
        $form = $this->createForm(Request1Type::class, $request);
        $form->handleRequest($httpRequest);
		$notes = $request->getNotes();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $note = new RequestNote();
            $note->setDate(new \DateTime());
            $note->setNote($form['note']->getData());
            $note->setAddedBy($this->getUser());
            
            $note->setRequest($request);
            $requestRepository->save($request, true);
    		$this->entityManager->persist($note);
    		$this->entityManager->persist($request);
    		$this->entityManager->flush();
            return $this->redirectToRoute('app_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('request/edit.html.twig', [
            'request' => $request,
			'notes' => $notes,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_request_delete', methods: ['POST'])]
    public function delete(HttpRequest $httpRequest, Request $request, RequestRepository $requestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$request->getId(), $request->request->get('_token'))) {
            $requestRepository->remove($request, true);
        }

        return $this->redirectToRoute('app_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
