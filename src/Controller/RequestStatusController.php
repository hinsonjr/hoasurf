<?php

namespace App\Controller;

use App\Entity\RequestStatus;
use App\Form\RequestStatusType;
use App\Repository\RequestStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/request/status')]
class RequestStatusController extends AbstractController
{
    #[Route('/', name: 'app_request_status_index', methods: ['GET'])]
    public function index(RequestStatusRepository $requestStatusRepository): Response
    {
        return $this->render('request_status/index.html.twig', [
            'request_statuses' => $requestStatusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_request_status_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RequestStatusRepository $requestStatusRepository): Response
    {
        $requestStatus = new RequestStatus();
        $form = $this->createForm(RequestStatusType::class, $requestStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requestStatusRepository->save($requestStatus, true);

            return $this->redirectToRoute('app_request_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('request_status/new.html.twig', [
            'request_status' => $requestStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_request_status_show', methods: ['GET'])]
    public function show(RequestStatus $requestStatus): Response
    {
        return $this->render('request_status/show.html.twig', [
            'request_status' => $requestStatus,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_request_status_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RequestStatus $requestStatus, RequestStatusRepository $requestStatusRepository): Response
    {
        $form = $this->createForm(RequestStatusType::class, $requestStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requestStatusRepository->save($requestStatus, true);

            return $this->redirectToRoute('app_request_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('request_status/edit.html.twig', [
            'request_status' => $requestStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_request_status_delete', methods: ['POST'])]
    public function delete(Request $request, RequestStatus $requestStatus, RequestStatusRepository $requestStatusRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$requestStatus->getId(), $request->request->get('_token'))) {
            $requestStatusRepository->remove($requestStatus, true);
        }

        return $this->redirectToRoute('app_request_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
