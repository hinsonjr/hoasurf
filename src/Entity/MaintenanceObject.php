<?php

namespace App\Entity;

use App\Repository\MaintenanceObjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaintenanceObjectRepository::class)
 */
class MaintenanceObject
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $period;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=2, nullable=true)
     */
    private $periodAmount;

    /**
     * @ORM\ManyToOne(targetEntity=Vendor::class, inversedBy="maintenanceObjects")
     */
    private $vendor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity=HOA::class, inversedBy="maintenanceObjects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hoa;

	
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(?string $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getPeriodAmount(): ?string
    {
        return $this->periodAmount;
    }

    public function setPeriodAmount(?string $periodAmount): self
    {
        $this->periodAmount = $periodAmount;

        return $this;
    }

    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    public function setVendor(?Vendor $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getHoa(): ?HOA
    {
        return $this->hoa;
    }

    public function setHoa(?HOA $hoa): self
    {
        $this->hoa = $hoa;

        return $this;
    }
}
