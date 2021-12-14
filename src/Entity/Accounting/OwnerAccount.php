<?php

namespace App\Entity\Accounting;

use App\Repository\Accounting\OwnerAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OwnerAccountRepository::class)
 */
class OwnerAccount
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
     * @ORM\Column(type="string", length=25)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=App\Entity\Owner::class, inversedBy="ownerAccounts")
     */
    private $owner;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, options={"default":0})
     */
    private $balance;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, options={"default":0})
     */
    private $startBalance;
	
    public function __construct()
    {
        $this->owner = new ArrayCollection();
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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

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

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }
}
