<?php

namespace App\Controller\Owner;

use App\Entity\Request;
use App\Entity\RequestStatus;
use App\Form\Owner\RequestNew;
use App\Form\Owner\RequestOwnerReply;
use App\Repository\RequestRepository;
use App\Repository\RequestTypeRepository;
use App\Repository\RequestStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/owner/request')]
class OwnerRequestController extends AbstractController
{
    
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    #[Route('/', name: 'owner_request_index', methods: ['GET'])]
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

    #[Route('/new', name: 'owner_request_new', methods: ['GET', 'POST'])]
    public function new(HttpRequest $httpRequest, RequestRepository $requestRepository): Response
    {
        $request = new Request();
        $form = $this->createForm(RequestNew::class, $request);
        $form->handleRequest($httpRequest);

        if ($form->isSubmitted() && $form->isValid()) {
            $requestRepository->save($request, true);

            return $this->redirectToRoute('app_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('owner_self/request/new.html.twig', [
            'request' => $request,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'owner_request_show', methods: ['GET'])]
    public function show(HttpRequest $httpRequest, Request $request): Response
    {
        return $this->render('request/show.html.twig', [
            'request' => $request,
        ]);
    }

    #[Route('/{id}/update-status', name: 'owner_request_update_status', methods: ['GET', 'POST'])]
    public function updateStatus(HttpRequest $httpRequest, Request $request, RequestRepository $requestRepository): Response
    {
		$newStatus = $httpRequest->request->get('status');
        $oldStatus = $request->getStatus();
        $status = new RequestStatus();
        $status->setStatus($newStatus);
        $request->setStatus($status);

        $now = new \DateTime;
        $request->setCompletedDate($now);
        $request->setCompletedBy($this->getUser());
        $this->doctrine->getManager()->persist($status);
        $this->doctrine->getManager()->persist($request);
        $this->doctrine->getManager()->flush();            
        
        return $this->json(['newStatus' => $newStatus, 'oldStatus' => $oldStatus]);
    }

    #[Route('/{id}/edit', name: 'owner_request_edit', methods: ['GET', 'POST'])]
    public function edit(HttpRequest $httpRequest, Request $request, RequestRepository $requestRepository): Response
    {
        $form = $this->createForm(RequestOwnerReply::class, $request);
        $form->handleRequest($httpRequest);
		$notes = $request->getNotes();
        if ($form->isSubmitted() && $form->isValid()) {
            $note = new \Apps\Entity\RequestNote();
            $note->setNote($form['note']->getData());
            $now = new \DateTime;
            $note->setDate($now);
            $note->setUser($this->getUser());
            if ($request->getStatus() != $form['request']->getStatus())
            {
                $request->setStatus($form['request']->getStatus());
                if ($form['request']->getStatus() === "Complete")
                {
                    $request->setCompletedDate($now);
                    $request->setCompletedBy($this->getUser());
                }
            }
            $request->addNote($note);
//            $requestRepository->save($request, true);
    		$this->getDoctrine()->getManager()->persist($note);
    		$this->getDoctrine()->getManager()->persist($request);
    		$this->getDoctrine()->getManager()->flush();            

            return $this->redirectToRoute('app_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('request/edit.html.twig', [
            'request' => $request,
			'notes' => $notes,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'owner_request_delete', methods: ['POST'])]
    public function delete(HttpRequest $httpRequest, Request $request, RequestRepository $requestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$request->getId(), $request->request->get('_token'))) {
            $requestRepository->remove($request, true);
        }

        return $this->redirectToRoute('app_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
