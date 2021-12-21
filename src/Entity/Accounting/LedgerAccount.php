<?php

namespace App\Entity\Accounting;

use App\Entity\Accounting\Transaction;
use App\Entity\HOA;
use App\Repository\Accounting\LedgerAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="creditAccount")
     */
    private $creditTransactions;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="debitAccount")
     */
    private $debitTransactions;

    /**
     * @ORM\ManyToOne(targetEntity=LedgerType::class, inversedBy="ledgerAccounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;


    public function __construct()
    {
        $this->type = new ArrayCollection();
        $this->hoa = new ArrayCollection();
        $this->creditTransactions = new ArrayCollection();
        $this->debitTransactions = new ArrayCollection();
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

    /**
     * @return Collection|Transaction[]
     */
    public function getCreditTransactions(): Collection
    {
        return $this->creditTransactions;
    }

    public function addCreditTransaction(Transaction $creditTransaction): self
    {
        if (!$this->creditTransactions->contains($creditTransaction)) {
            $this->creditTransactions[] = $creditTransaction;
            $creditTransaction->setCreditAccount($this);
        }

        return $this;
    }

    public function removeCreditTransaction(Transaction $creditTransaction): self
    {
        if ($this->creditTransactions->removeElement($creditTransaction)) {
            // set the owning side to null (unless already changed)
            if ($creditTransaction->getCreditAccount() === $this) {
                $creditTransaction->setCreditAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getDebitTransactions(): Collection
    {
        return $this->debitTransactions;
    }

    public function addDebitTransaction(Transaction $debitTransaction): self
    {
        if (!$this->debitTransactions->contains($debitTransaction)) {
            $this->debitTransactions[] = $debitTransaction;
            $debitTransaction->setDebitAccount($this);
        }

        return $this;
    }

    public function removeDebitTransaction(Transaction $debitTransaction): self
    {
        if ($this->debitTransactions->removeElement($debitTransaction)) {
            // set the owning side to null (unless already changed)
            if ($debitTransaction->getDebitAccount() === $this) {
                $debitTransaction->setDebitAccount(null);
            }
        }

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
}
