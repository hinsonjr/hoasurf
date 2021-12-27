<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OwnerDashController extends AbstractController
{
    #[Route('/owner/dash', name: 'owner_dash')]
    public function index(): Response
    {
        return $this->render('owner_dash/index.html.twig', [
            'controller_name' => 'OwnerDashController',
        ]);
    }
}
