<?php

namespace App\Entity\Accounting;

use App\Repository\Accounting\OwnerInvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OwnerInvoiceRepository::class)
 */
class OwnerInvoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=App\Entity\HOA::class, inversedBy="ownerInvoices")
     */
    private $hoa;

    /**
     * @ORM\ManyToMany(targetEntity=App\Entity\Owner::class, inversedBy="ownerInvoices")
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $amount;

    public function __construct()
    {
        $this->hoa = new ArrayCollection();
        $this->owner = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Owner[]
     */
    public function getOwner(): Collection
    {
        return $this->owner;
    }

    public function addOwner(Owner $owner): self
    {
        if (!$this->owner->contains($owner)) {
            $this->owner[] = $owner;
        }

        return $this;
    }

    public function removeOwner(Owner $owner): self
    {
        $this->owner->removeElement($owner);

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
}
