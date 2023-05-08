<?php

namespace App\Entity\Accounting;

use App\Entity\Accounting\LedgerAccount;
use App\Repository\HoaReportCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoaReportCategoryRepository::class)]
class HoaReportCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column]
    private ?int $ordering = 150;

    #[ORM\OneToMany(mappedBy: 'hoaReportCategory', targetEntity: LedgerAccount::class)]
    private Collection $ledgerAccounts;

    public function __construct()
    {
        $this->ledgerAccounts = new ArrayCollection();
    }

	public function __toString(): string
    {
        return $this->getCategory();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getOrdering(): ?int
    {
        return $this->ordering;
    }

    public function setOrdering(int $ordering): self
    {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * @return Collection<int, LedgerAccount>
     */
    public function getLedgerAccounts(): Collection
    {
        return $this->ledgerAccounts;
    }

    public function addLedgerAccount(LedgerAccount $ledgerAccount): self
    {
        if (!$this->ledgerAccounts->contains($ledgerAccount)) {
            $this->ledgerAccounts->add($ledgerAccount);
            $ledgerAccount->setHoaReportCategory($this);
        }

        return $this;
    }

    public function removeLedgerAccount(LedgerAccount $ledgerAccount): self
    {
        if ($this->ledgerAccounts->removeElement($ledgerAccount)) {
            // set the owning side to null (unless already changed)
            if ($ledgerAccount->getHoaReportCategory() === $this) {
                $ledgerAccount->setHoaReportCategory(null);
            }
        }

        return $this;
    }
}
