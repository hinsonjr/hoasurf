<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Accounting\LedgerAccount;

class AdminDashController extends AbstractController
{
    #[Route('/admin/dash', name: 'admin_dash')]
    public function index(): Response
    {
		$user = $this->getUser();
		$activeHoa = $user->getActiveHoa();
        return $this->render('admin_dash/index.html.twig', [
            'controller_name' => 'AdminDashController',
			'activeHoa' => $activeHoa,
        ]);
    }

    #[Route('/admin/balance_update', name: 'admin_balance_update')]
	public function recalculateAccountBalances(ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
	{
		$tableClass = "adminTable";
		$repo = $doctrine->getRepository(LedgerAccount::class);
		$accounts = $repo->findAll();
		$heading = '<th style="padding-right:10px">Account</th><th style="padding-right:10px">isDebit</th><th style="padding-right:10px">Previous Balance</th><th style="padding-right:10px">Updated Balance</th>';
		$results = [];
		foreach ($accounts as $account)
		{
			$isDebit = $account->getType()->getIsDebit();
			$previousBalance = $account->getBalance();
			$balance = $account->getStartBalance();
			foreach ($account->getDebitTransactions() as $debit)
			{
				if ($isDebit)
				{
					$balance += $debit->getAmount();
				}
				else
				{
					$balance -= $debit->getAmount();
				}
			}
			foreach ($account->getCreditTransactions() as $debit)
			{
				if ($isDebit)
				{
					$balance -= $debit->getAmount();
				}
				else
				{
					$balance += $debit->getAmount();
				}
			}
			$account->setBalance($balance);
			$entityManager->persist($account);
			$results[] = [$account->getName(), $account->getType()->getIsDebit() ? "true " : "false ",
				"$".number_format($previousBalance,2),"$".number_format($balance,2)];
		}
		$entityManager->flush();
		

        return $this->renderForm('admin-blank.html.twig', [
            'title' => "Account Rebalance",
            'content' => $results,
			'heading' => $heading,
			'table-class' => $tableClass
        ]);
	}
}
