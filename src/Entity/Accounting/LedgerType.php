<?php

namespace App\Entity\Accounting;

use App\Repository\Accounting\LedgerTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LedgerTypeRepository::class)
 */
class LedgerType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=24)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDebit;

    /**
     * @ORM\OneToMany(targetEntity=LedgerAccount::class, mappedBy="type")
     */
    private $ledgerAccounts;

    public function __construct()
    {
        $this->ledgerAccounts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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

    public function getIsDebit(): ?bool
    {
        return $this->isDebit;
    }

    public function setIsDebit(bool $isDebit): self
    {
        $this->isDebit = $isDebit;

        return $this;
    }

    /**
     * @return Collection|LedgerAccount[]
     */
    public function getLedgerAccounts(): Collection
    {
        return $this->ledgerAccounts;
    }

    public function addLedgerAccount(LedgerAccount $ledgerAccount): self
    {
        if (!$this->ledgerAccounts->contains($ledgerAccount)) {
            $this->ledgerAccounts[] = $ledgerAccount;
            $ledgerAccount->setType($this);
        }

        return $this;
    }

    public function removeLedgerAccount(LedgerAccount $ledgerAccount): self
    {
        if ($this->ledgerAccounts->removeElement($ledgerAccount)) {
            // set the owning side to null (unless already changed)
            if ($ledgerAccount->getType() === $this) {
                $ledgerAccount->setType(null);
            }
        }

        return $this;
    }
}
