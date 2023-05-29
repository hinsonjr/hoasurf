<?php

namespace App\Entity;

use App\Entity\Accounting\OwnerInvoice;
use App\Repository\UnitOwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitOwnerRepository::class)]
class UnitOwner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'unitOwner')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Owner $owner = null;

    #[ORM\ManyToOne(inversedBy: 'unitOwner')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Unit $unit = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $ownPercent = null;

    #[ORM\OneToMany(mappedBy: 'unitOwner', targetEntity: OwnerInvoice::class)]
    private Collection $ownerInvoices;

    public function __construct()
    {
        $this->ownerInvoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

	public function __toString()
                           	{
                           		return $this->unit->getUnitNumber();
                           	}
	
    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getOwnPercent(): ?int
    {
        return $this->ownPercent;
    }

    public function setOwnPercent(?int $ownPercent): self
    {
        $this->ownPercent = $ownPercent;

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
            $ownerInvoice->setUnitOwner($this);
        }

        return $this;
    }

    public function removeOwnerInvoice(OwnerInvoice $ownerInvoice): self
    {
        if ($this->ownerInvoices->removeElement($ownerInvoice)) {
            // set the owning side to null (unless already changed)
            if ($ownerInvoice->getUnitOwner() === $this) {
                $ownerInvoice->setUnitOwner(null);
            }
        }

        return $this;
    }
}
