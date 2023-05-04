<?php

namespace App\Controller;

use App\Entity\MessageCategory;
use App\Form\MessageCategoryType;
use App\Repository\MessageCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/messageCategory')]
class MessageCategoryController extends AbstractController
{
    #[Route('/', name: 'app_message_category_index', methods: ['GET'])]
    public function index(MessageCategoryRepository $messageCategoryRepository): Response
    {
        return $this->render('message_category/index.html.twig', [
            'message_categories' => $messageCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_message_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessageCategoryRepository $messageCategoryRepository): Response
    {
        $messageCategory = new MessageCategory();
        $form = $this->createForm(MessageCategoryType::class, $messageCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageCategoryRepository->save($messageCategory, true);

            return $this->redirectToRoute('app_message_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message_category/new.html.twig', [
            'message_category' => $messageCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_category_show', methods: ['GET'])]
    public function show(MessageCategory $messageCategory): Response
    {
        return $this->render('message_category/show.html.twig', [
            'message_category' => $messageCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_message_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MessageCategory $messageCategory, MessageCategoryRepository $messageCategoryRepository): Response
    {
        $form = $this->createForm(MessageCategoryType::class, $messageCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageCategoryRepository->save($messageCategory, true);

            return $this->redirectToRoute('app_message_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message_category/edit.html.twig', [
            'message_category' => $messageCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_category_delete', methods: ['POST'])]
    public function delete(Request $request, MessageCategory $messageCategory, MessageCategoryRepository $messageCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$messageCategory->getId(), $request->request->get('_token'))) {
            $messageCategoryRepository->remove($messageCategory, true);
        }

        return $this->redirectToRoute('app_message_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
