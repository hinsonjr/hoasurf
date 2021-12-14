<?php

namespace App\Entity\Accounting;

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
     * @ORM\ManyToMany(targetEntity=LedgerType::class, inversedBy="ledgerAccounts")
     */
    private $type;

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

    public function __construct()
    {
        $this->type = new ArrayCollection();
        $this->hoa = new ArrayCollection();
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
     * @return Collection|LedgerType[]
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(LedgerType $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
        }

        return $this;
    }

    public function removeType(LedgerType $type): self
    {
        $this->type->removeElement($type);

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
}
