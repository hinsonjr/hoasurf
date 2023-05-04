<?php

namespace App\Controller;

use App\Entity\MessageType;
use App\Form\MessageTypeType;
use App\Repository\MessageTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/messageType')]
class MessageTypeController extends AbstractController
{
    #[Route('/', name: 'app_message_type_index', methods: ['GET'])]
    public function index(MessageTypeRepository $messageTypeRepository): Response
    {
        return $this->render('message_type/index.html.twig', [
            'message_types' => $messageTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_message_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessageTypeRepository $messageTypeRepository): Response
    {
        $messageType = new MessageType();
        $form = $this->createForm(MessageTypeType::class, $messageType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageTypeRepository->save($messageType, true);

            return $this->redirectToRoute('app_message_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message_type/new.html.twig', [
            'message_type' => $messageType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_type_show', methods: ['GET'])]
    public function show(MessageType $messageType): Response
    {
        return $this->render('message_type/show.html.twig', [
            'message_type' => $messageType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_message_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MessageType $messageType, MessageTypeRepository $messageTypeRepository): Response
    {
        $form = $this->createForm(MessageTypeType::class, $messageType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageTypeRepository->save($messageType, true);

            return $this->redirectToRoute('app_message_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message_type/edit.html.twig', [
            'message_type' => $messageType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_type_delete', methods: ['POST'])]
    public function delete(Request $request, MessageType $messageType, MessageTypeRepository $messageTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$messageType->getId(), $request->request->get('_token'))) {
            $messageTypeRepository->remove($messageType, true);
        }

        return $this->redirectToRoute('app_message_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
