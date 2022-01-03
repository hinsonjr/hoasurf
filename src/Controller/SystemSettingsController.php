<?php

namespace App\Controller;

use App\Entity\SystemSettings;
use App\Form\SystemSettingsType;
use App\Repository\SystemSettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/system/settings')]
class SystemSettingsController extends AbstractController
{
    #[Route('/', name: 'system_settings_index', methods: ['GET'])]
    public function index(SystemSettingsRepository $systemSettingsRepository): Response
    {
        return $this->render('system_settings/index.html.twig', [
            'system_settings' => $systemSettingsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'system_settings_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $systemSetting = new SystemSettings();
        $form = $this->createForm(SystemSettingsType::class, $systemSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($systemSetting);
            $entityManager->flush();

            return $this->redirectToRoute('system_settings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('system_settings/new.html.twig', [
            'system_setting' => $systemSetting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'system_settings_show', methods: ['GET'])]
    public function show(SystemSettings $systemSetting): Response
    {
        return $this->render('system_settings/show.html.twig', [
            'system_setting' => $systemSetting,
        ]);
    }

    #[Route('/{id}/edit', name: 'system_settings_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SystemSettings $systemSetting, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SystemSettingsType::class, $systemSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('system_settings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('system_settings/edit.html.twig', [
            'system_setting' => $systemSetting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'system_settings_delete', methods: ['POST'])]
    public function delete(Request $request, SystemSettings $systemSetting, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$systemSetting->getId(), $request->request->get('_token'))) {
            $entityManager->remove($systemSetting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('system_settings_index', [], Response::HTTP_SEE_OTHER);
    }
}
