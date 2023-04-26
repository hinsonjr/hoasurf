<?php

namespace App\Entity\Accounting;

use App\Repository\Accounting\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Accounting\LedgerAccount;
use App\Service\Dbg;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private $id;

	#[ORM\Column(type: "datetime")]
	private $date;

	#[ORM\Column(type: "decimal", precision: 12, scale: 2)]
	private $amount;

	#[ORM\ManyToOne(targetEntity: LedgerAccount::class, inversedBy: "creditTransactions")]
	#[ORM\JoinColumn(nullable: false)]
	private $creditAccount;

	#[ORM\ManyToOne(targetEntity: LedgerAccount::class, inversedBy: "debitTransactions")]
	#[ORM\JoinColumn(nullable: false)]
	private $debitAccount;

	#[ORM\Column(type: "boolean")]
	private $deleted;

	public function __construct($debitAcct = null, $creditAcct = null)
	{
		$this->date = new \DateTime();
//		$this->dbg = new Dbg();
//
//		$this->dbg->log("DebitAcct=",$debitAcct->name,2);
//		$this->dbg->log("CreditAcct=",$creditAcct->name,2);
		if ($debitAcct)
		{
			$this->setDebitAccount($debitAcct);
		}
		if ($creditAcct)
		{
			$this->setCreditAccount($creditAcct);
		}
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getDate(): ?\DateTimeInterface
	{
		return $this->date;
	}

	public function setDate(\DateTimeInterface $date): self
	{
		$this->date = $date;

		return $this;
	}

	public function getAmount(): ?string
	{
		return $this->amount;
	}

	public function setAmount(string $amount): self
	{
		$this->amount = $amount;

		return $this;
	}

	public function getCreditAccount(): ?LedgerAccount
	{
		return $this->creditAccount;
	}

	public function setCreditAccount(?LedgerAccount $creditAccount): self
	{
		$this->creditAccount = $creditAccount;

		return $this;
	}

	public function getDebitAccount(): ?LedgerAccount
	{
		return $this->debitAccount;
	}

	public function setDebitAccount(?LedgerAccount $debitAccount): self
	{
		$this->debitAccount = $debitAccount;

		return $this;
	}

	public function getDeleted(): ?bool
	{
		return $this->deleted;
	}

	public function setDeleted(bool $deleted): self
	{
		$this->deleted = $deleted;

		return $this;
	}

}
