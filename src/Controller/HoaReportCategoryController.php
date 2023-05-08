<?php

namespace App\Controller;

use App\Entity\Accounting\HoaReportCategory;
use App\Form\HoaReportCategoryType;
use App\Repository\HoaReportCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accounting/hoaReportCategory')]
class HoaReportCategoryController extends AbstractController
{
    #[Route('/', name: 'app_hoa_report_category_index', methods: ['GET'])]
    public function index(HoaReportCategoryRepository $hoaReportCategoryRepository): Response
    {
        return $this->render('accounting/hoa_report_category/index.html.twig', [
            'hoa_report_categories' => $hoaReportCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hoa_report_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HoaReportCategoryRepository $hoaReportCategoryRepository): Response
    {
        $hoaReportCategory = new HoaReportCategory();
        $form = $this->createForm(HoaReportCategoryType::class, $hoaReportCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hoaReportCategoryRepository->save($hoaReportCategory, true);

            return $this->redirectToRoute('app_hoa_report_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/hoa_report_category/new.html.twig', [
            'hoa_report_category' => $hoaReportCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hoa_report_category_show', methods: ['GET'])]
    public function show(HoaReportCategory $hoaReportCategory): Response
    {
        return $this->render('accounting/hoa_report_category/show.html.twig', [
            'hoa_report_category' => $hoaReportCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hoa_report_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HoaReportCategory $hoaReportCategory, HoaReportCategoryRepository $hoaReportCategoryRepository): Response
    {
        $form = $this->createForm(HoaReportCategoryType::class, $hoaReportCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hoaReportCategoryRepository->save($hoaReportCategory, true);

            return $this->redirectToRoute('app_hoa_report_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accounting/hoa_report_category/edit.html.twig', [
            'hoa_report_category' => $hoaReportCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hoa_report_category_delete', methods: ['POST'])]
    public function delete(Request $request, HoaReportCategory $hoaReportCategory, HoaReportCategoryRepository $hoaReportCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hoaReportCategory->getId(), $request->request->get('_token'))) {
            $hoaReportCategoryRepository->remove($hoaReportCategory, true);
        }

        return $this->redirectToRoute('app_hoa_report_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
