<?php

namespace App\Entity\Accounting;

use App\Repository\Accounting\OwnerInvoiceTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OwnerInvoiceTypeRepository::class)]
class OwnerInvoiceType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $type = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?LedgerAccount $creditAccount = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?LedgerAccount $debitAccount = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: OwnerInvoice::class)]
    private Collection $ownerInvoices;

    public function __construct()
    {
        $this->ownerInvoices = new ArrayCollection();
    }

	public function __toString()
    {
        return $this->getType();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    /**
     * @return Collection<int, OwnerInvoice>
     */
    public function getOwnerInvoices(): Collection
    {
        return $this->ownerInvoices;
    }

    public function addOwnerInvoice(OwnerInvoice $ownerInvoice): self
    {
        if (!$this->ownerInvoices->contains($ownerInvoice)) {
            $this->ownerInvoices->add($ownerInvoice);
            $ownerInvoice->setType($this);
        }

        return $this;
    }

    public function removeOwnerInvoice(OwnerInvoice $ownerInvoice): self
    {
        if ($this->ownerInvoices->removeElement($ownerInvoice)) {
            // set the owning side to null (unless already changed)
            if ($ownerInvoice->getType() === $this) {
                $ownerInvoice->setType(null);
            }
        }

        return $this;
    }
}
