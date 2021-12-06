<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImporterController extends AbstractController
{
    #[Route('/admin/importer', name: 'importer')]
    public function index(): Response
    {
		$tableList = ["<choose table>" => null, 'Units' => "unit",'Owners' => "owner",'Buildings' => "building",'Unit-Owners' => "unit_owner"];
		$importForm = $this->createFormBuilder()
			->add('csvFile', FileType::class)
			->add('table', ChoiceType::class, ['choices' => $tableList, ])
			->getForm();
        return $this->render('importer/step1.html.twig', [
            'controller_name' => 'ImporterController',
			'form' => $importForm->createView(),
        ]);
    }
}
