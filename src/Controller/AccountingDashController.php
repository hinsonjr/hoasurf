<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountingDashController extends AbstractController
{
    #[Route('/accounting/dash', name: 'accounting_dash')]
    public function index(): Response
    {
        return $this->render('accounting_dash/index.html.twig', [
            'controller_name' => 'AccountingDashController',
        ]);
    }
}
