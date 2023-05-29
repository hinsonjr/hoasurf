<?php

namespace App\Entity\Accounting;

use App\Repository\Accounting\OwnerInvoiceRepository;
use App\Entity\Accounting\Transaction;
use App\Entity\Hoa;
use App\Entity\UnitOwner;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OwnerInvoiceRepository::class)]
class OwnerInvoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'ownerInvoice')]
    private ?Transaction $transaction = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dueDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $paidDate = null;

    #[ORM\ManyToOne(inversedBy: 'ownerInvoices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hoa $hoa = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $postDate = null;

    #[ORM\ManyToOne(inversedBy: 'ownerInvoices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OwnerInvoiceType $type = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    private ?string $amount = null;

    #[ORM\ManyToOne(inversedBy: 'ownerInvoices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UnitOwner $unitOwner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(?Transaction $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getPaidDate(): ?\DateTimeInterface
    {
        return $this->paidDate;
    }

    public function setPaidDate(?\DateTimeInterface $paidDate): self
    {
        $this->paidDate = $paidDate;

        return $this;
    }

    public function getHoa(): ?Hoa
    {
        return $this->hoa;
    }

    public function setHoa(?Hoa $hoa): self
    {
        $this->hoa = $hoa;

        return $this;
    }

    public function getPostDate(): ?\DateTimeInterface
    {
        return $this->postDate;
    }

    public function setPostDate(\DateTimeInterface $postDate): self
    {
        $this->postDate = $postDate;

        return $this;
    }

    public function getType(): ?OwnerInvoiceType
    {
        return $this->type;
    }

    public function setType(?OwnerInvoiceType $type): self
    {
        $this->type = $type;

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

    public function getUnitOwner(): ?UnitOwner
    {
        return $this->unitOwner;
    }

    public function setUnitOwner(?UnitOwner $unitOwner): self
    {
        $this->unitOwner = $unitOwner;

        return $this;
    }
}
