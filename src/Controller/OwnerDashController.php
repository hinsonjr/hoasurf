<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use App\Entity\Owner;

class OwnerDashController extends AbstractController
{
	private $security;
	
	public function __construct(Security $security, ManagerRegistry $doctrine)
	{
		$this->security = $security;
		$this->doctrine = $doctrine;
	}
	
    #[Route('/owner/dash', name: 'owner_dash')]
    public function index(): Response
    {
		$repo = $this->doctrine->getRepository(Owner::class);
		$ownerRecords = $repo->findByUser($this->security->getUser());
		/********$repo->findTransactions(Hoa $hoa, $cnt);**/ 
		$heading = '<th style="padding-right:10px">Account</th><th style="padding-right:10px">isDebit</th><th style="padding-right:10px">Previous Balance</th><th style="padding-right:10px">Updated Balance</th>';
		$results = [];
        return $this->render('owner_dash/index.html.twig', [
            'controller_name' => 'OwnerDashController',
			'owner_records' => $ownerRecords
        ]);
    }
}
