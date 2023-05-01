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

    #[ORM\ManyToMany(targetEntity: Owner::class, mappedBy: 'units')]
    private Collection $owners;

	public function __construct()
             {
                 $this->owners = new ArrayCollection();
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
     * @return Collection<int, Owner>
     */
    public function getOwners(): Collection
    {
        return $this->owners;
    }

    public function addOwner(Owner $owner): self
    {
        if (!$this->owners->contains($owner)) {
            $this->owners->add($owner);
            $owner->addUnit($this);
        }

        return $this;
    }

    public function removeOwner(Owner $owner): self
    {
        if ($this->owners->removeElement($owner)) {
            $owner->removeUnit($this);
        }

        return $this;
    }

 }
