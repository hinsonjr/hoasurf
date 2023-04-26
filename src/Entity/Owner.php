<?php

namespace App\Entity;

use App\Entity\Accounting\LedgerAccount;
use App\Repository\OwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OwnerRepository::class)]
class Owner
{

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private $id;

	#[ORM\Column(type: "string", length: 200)]
	private $name;

	#[ORM\Column(type: "date", nullable: true)]
	private $startDate;

	#[ORM\Column(type: "date", nullable: true)]
	private $endDate;

	#[ORM\Column(type: "string", length: 100, nullable: true)]
	private $address;

	#[ORM\Column(type: "string", length: 80, nullable: true)]
	private $address2;

	#[ORM\Column(type: "string", length: 100, nullable: true)]
	private $city;

	#[ORM\Column(type: "string", length: 50, nullable: true)]
	private $state;

	#[ORM\Column(type: "string", length: 10, nullable: true)]
	private $zip;

	#[ORM\Column(type: "string", length: 20, nullable: true)]
	private $phone;

	#[ORM\ManyToOne(targetEntity: Unit::class, inversedBy: "owners")]
	private $unit;

	#[ORM\Column(type: "string", length: 100, nullable: true)]
	private $country;

	#[ORM\Column(type: "float")]
	private $ownPercent;

	#[ORM\ManyToOne(targetEntity: User::class, inversedBy: "owners")]
	private $user;

	#[ORM\OneToMany(targetEntity: LedgerAccount::class, mappedBy: "owner")]
	private $ledgerAccounts;

	#[ORM\Column(type: "string", length: 255, nullable: true)]
	private $email;

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

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function setAddress(?string $address): self
	{
		$this->address = $address;

		return $this;
	}

	public function getAddress2(): ?string
	{
		return $this->address2;
	}

	public function setAddress2(?string $address2): self
	{
		$this->address2 = $address2;

		return $this;
	}

	public function getCity(): ?string
	{
		return $this->city;
	}

	public function setCity(?string $city): self
	{
		$this->city = $city;

		return $this;
	}

	public function getState(): ?string
	{
		return $this->state;
	}

	public function setState(?string $state): self
	{
		$this->state = $state;

		return $this;
	}

	public function getZip(): ?string
	{
		return $this->zip;
	}

	public function setZip(?string $zip): self
	{
		$this->zip = $zip;

		return $this;
	}

	public function getPhone(): ?string
	{
		return $this->phone;
	}

	public function setPhone(?string $phone): self
	{
		$this->phone = $phone;

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

	public function getCountry(): ?string
	{
		return $this->country;
	}

	public function setCountry(?string $country): self
	{
		$this->country = $country;

		return $this;
	}

	public function getOwnPercent(): ?float
	{
		return $this->ownPercent;
	}

	public function setOwnPercent(float $ownPercent): self
	{
		$this->ownPercent = $ownPercent;

		return $this;
	}

	public function getUser(): ?User
	{
		return $this->user;
	}

	public function setUser(?User $user): self
	{
		$this->user = $user;

		return $this;
	}

//    @return Collection|LedgerAccount[]
	public function getLedgerAccounts(): Collection
	{
		return $this->ledgerAccounts;
	}

	public function addLedgerAccount(LedgerAccount $ledgerAccount): self
	{
		if (!$this->ledgerAccounts->contains($ledgerAccount))
		{
			$this->ledgerAccounts[] = $ledgerAccount;
			$ledgerAccount->setOwner($this);
		}

		return $this;
	}

	public function removeLedgerAccount(LedgerAccount $ledgerAccount): self
	{
		if ($this->ledgerAccounts->removeElement($ledgerAccount))
		{
			// set the owning side to null (unless already changed)
			if ($ledgerAccount->getOwner() === $this)
			{
				$ledgerAccount->setOwner(null);
			}
		}

		return $this;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(?string $email): self
	{
		$this->email = $email;

		return $this;
	}

}
