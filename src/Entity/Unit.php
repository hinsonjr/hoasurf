<?php

namespace App\Entity;

use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
class Unit
{

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private $id;

	#[ORM\Column(type: "string", length: 30)]
	private $unitNumber;

	#[ORM\Column(type: "text", nullable: true)]
	private $description;

	#[ORM\Column(type: "string", length: 10, nullable: true)]
	private $sf;

	#[ORM\Column(type: "string", length: 5, nullable: true)]
	private $beds;

	#[ORM\Column(type: "string", length: 5, nullable: true)]
	private $baths;

	#[ORM\ManyToOne(targetEntity: Building::class, inversedBy: "units")]
	private $building;

	#[ORM\OneToMany(mappedBy: 'unit', targetEntity: UnitOwners::class)]
	private Collection $unitOwners;

	public function __construct()
	{
		$this->unitOwners = new ArrayCollection();
	}

	public function __toString()
	{
		return $this->getUnitNumber() . "-" . $this->getBuilding();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getUnitNumber(): ?string
	{
		return $this->unitNumber;
	}

	public function setUnitNumber(string $unitNumber): self
	{
		$this->unitNumber = $unitNumber;

		return $this;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description): self
	{
		$this->description = $description;

		return $this;
	}

	public function getSf(): ?string
	{
		return $this->sf;
	}

	public function setSf(?string $sf): self
	{
		$this->sf = $sf;

		return $this;
	}

	public function getBeds(): ?string
	{
		return $this->beds;
	}

	public function setBeds(?string $beds): self
	{
		$this->beds = $beds;

		return $this;
	}

	public function getBaths(): ?string
	{
		return $this->baths;
	}

	public function setBaths(?string $baths): self
	{
		$this->baths = $baths;

		return $this;
	}

	public function getBuilding(): ?building
	{
		return $this->building;
	}

	public function setBuilding(?building $building): self
	{
		$this->building = $building;
		return $this;
	}

	/**
	 * @return Collection<int, UnitOwners>
	 */
	public function getUnitOwners(): Collection
	{
		return $this->unitOwners;
	}

	public function addOwnerUnit(UnitOwners $ownerUnit): self
	{
		if (!$this->unitOwners->contains($ownerUnit))
		{
			$this->unitOwners->add($ownerUnit);
			$ownerUnit->setUnit($this);
		}

		return $this;
	}

	public function removeOwnerUnit(UnitOwners $ownerUnit): self
	{
		if ($this->unitOwners->removeElement($ownerUnit))
		{
			// set the owning side to null (unless already changed)
			if ($ownerUnit->getUnit() === $this)
			{
				$ownerUnit->setUnit(null);
			}
		}

		return $this;
	}

}
