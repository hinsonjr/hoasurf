<?php

namespace App\Entity\Accounting;

use App\Entity\Accounting\Transaction;
use App\Entity\HOA;
use App\Repository\Accounting\LedgerAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\AccountTransactionTrait;

/**
 * @ORM\Entity(repositoryClass=LedgerAccountRepository::class)
 */
class LedgerAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=HOA::class, inversedBy="ledgerAccounts")
     */
    private $hoa;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, options={"default": 0})
     */
    private $balance;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, options={"default": 0})
     */
    private $startBalance;

    /**
     * @ORM\ManyToOne(targetEntity=LedgerType::class, inversedBy="ledgerAccounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;
	
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Accounting\Transaction", mappedBy="debitAccount", orphanRemoval=true)
	 */
	private $debitTransactions;	

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Accounting\Transaction", mappedBy="creditAccount", orphanRemoval=true)
	 */
	private $creditTransactions;	

    public function __construct()
    {
        $this->type = new ArrayCollection();
        $this->hoa = new ArrayCollection();
        $this->debitTransactions = new ArrayCollection();		
        $this->creditTransactions = new ArrayCollection();		
    }

	public function __toString()
      	{
      		return $this->name;
      	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|HOA[]
     */
    public function getHoa(): Collection
    {
        return $this->hoa;
    }

    public function addHoa(HOA $hoa): self
    {
        if (!$this->hoa->contains($hoa)) {
            $this->hoa[] = $hoa;
        }

        return $this;
    }

    public function removeHoa(HOA $hoa): self
    {
        $this->hoa->removeElement($hoa);

        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getStartBalance(): ?string
    {
        return $this->startBalance;
    }

    public function setStartBalance(string $startBalance): self
    {
        $this->startBalance = $startBalance;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

	public function setType(?LedgerType $type): self
    {
        $this->type = $type;

        return $this;
    }
	

    /**
     * @return Collection|Transaction[]
     */
    public function getDebitTransactions(): Collection
    {
        return $this->debitTransactions;
    }

    public function addDebitTransaction(Transaction $transaction): self
    {
        if (!$this->debitTransactions->contains($transaction)) {
            $this->debitTransactions[] = $transaction;
            $transaction->setDebitAccount($this);
        }

        return $this;
    }

    public function removeDebitTransaction(Transaction $transaction): self
    {
        if ($this->debitTransactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getDebitAccount() === $this) {
                $transaction->setDebitAccount(null);
            }
        }

        return $this;
    }	

    /**
     * @return Collection|Transaction[]
     */
    public function getCreditTransactions(): Collection
    {
        return $this->creditTransactions;
    }

    public function addCreditTransaction(Transaction $transaction): self
    {
        if (!$this->creditTransactions->contains($transaction)) {
            $this->creditTransactions[] = $transaction;
            $transaction->setCreditAccount($this);
        }

        return $this;
    }

    public function removeCreditTransaction(Transaction $transaction): self
    {
        if ($this->creditTransactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCreditAccount() === $this) {
                $transaction->setCreditAccount(null);
            }
        }

        return $this;
    }	

	
}
