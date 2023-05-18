<?php

namespace App\Controller;

use App\Entity\RequestType;
use App\Form\RequestTypeType;
use App\Repository\RequestTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/requestType')]
class RequestTypeController extends AbstractController
{
    #[Route('/', name: 'app_request_type_index', methods: ['GET'])]
    public function index(RequestTypeRepository $requestTypeRepository): Response
    {
        return $this->render('request_type/index.html.twig', [
            'request_types' => $requestTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_request_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RequestTypeRepository $requestTypeRepository): Response
    {
        $requestType = new RequestType();
        $form = $this->createForm(RequestTypeType::class, $requestType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requestTypeRepository->save($requestType, true);

            return $this->redirectToRoute('app_request_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('request_type/new.html.twig', [
            'request_type' => $requestType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_request_type_show', methods: ['GET'])]
    public function show(RequestType $requestType): Response
    {
        return $this->render('request_type/show.html.twig', [
            'request_type' => $requestType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_request_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RequestType $requestType, RequestTypeRepository $requestTypeRepository): Response
    {
        $form = $this->createForm(RequestTypeType::class, $requestType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requestTypeRepository->save($requestType, true);

            return $this->redirectToRoute('app_request_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('request_type/edit.html.twig', [
            'request_type' => $requestType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_request_type_delete', methods: ['POST'])]
    public function delete(Request $request, RequestType $requestType, RequestTypeRepository $requestTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$requestType->getId(), $request->request->get('_token'))) {
            $requestTypeRepository->remove($requestType, true);
        }

        return $this->redirectToRoute('app_request_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
