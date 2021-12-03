<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashController extends AbstractController
{
    #[Route('/admin/dash', name: 'admin_dash')]
    public function index(): Response
    {
        return $this->render('admin_dash/index.html.twig', [
            'controller_name' => 'AdminDashController',
        ]);
    }
}
