<?php

namespace App\Entity\Accounting;

use App\Repository\Accounting\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Accounting\LedgerAccount;
use App\Service\Dbg;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PostPersistEventArgs;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\HasLifecycleCallbacks]
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
	private $deleted = false;

	#[ORM\OneToOne(mappedBy: 'transaction', cascade: ['persist', 'remove'])]
	private ?OwnerInvoice $ownerInvoice = null;
	
	public function __construct($debitAcct = null, $creditAcct = null)
	{
		$this->date = new \DateTime();
		if ($debitAcct)
		{
			$this->setDebitAccount($debitAcct);
		}
		if ($creditAcct)
		{
			$this->setCreditAccount($creditAcct);
		}
	}

	public function __toString()
	{
		return $this->getId();
	}
	
	#[ORM\PrePersist]
	public function updateBalances(PrePersistEventArgs $args): void
	{
		$transaction = $args->getObject();
		$debitAcct = $transaction->getDebitAccount();
		$creditAcct = $transaction->getCreditAccount();
		if ($debitAcct->getType()->getIsDebit())
		{
			$debitAcct->setBalance($debitAcct->getBalance() - $transaction->getAmount());
			$creditAcct->setBalance($creditAcct->getBalance() + $transaction->getAmount());
			
		}
		else
		{
			$debitAcct->setBalance($debitAcct->getBalance() + $transaction->getAmount());
			$creditAcct->setBalance($creditAcct->getBalance() - $transaction->getAmount());
		}
	}	
	
	#[ORM\PostPersist]
	public function persistBalances(PostPersistEventArgs $args): void
	{
		$transaction = $args->getObject();
		$em = $args->getObjectManager();
		$debitAcct = $transaction->getDebitAccount();
		$creditAcct = $transaction->getCreditAccount();
		$em->persist($debitAcct);
		$em->persist($creditAcct);
        $em->flush();
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
