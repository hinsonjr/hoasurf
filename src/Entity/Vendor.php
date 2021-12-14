<?php

namespace App\Entity;

use App\Repository\VendorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VendorRepository::class)
 */
class Vendor
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
    private $contactName;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $contactNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=MaintenanceObject::class, mappedBy="vendor")
     */
    private $maintenanceObjects;

    public function __construct()
    {
        $this->maintenanceObjects = new ArrayCollection();
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

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(?string $contactName): self
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getContactNumber(): ?string
    {
        return $this->contactNumber;
    }

    public function setContactNumber(string $contactNumber): self
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): self
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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

    /**
     * @return Collection|MaintenanceObject[]
     */
    public function getMaintenanceObjects(): Collection
    {
        return $this->maintenanceObjects;
    }

    public function addMaintenanceObject(MaintenanceObject $maintenanceObject): self
    {
        if (!$this->maintenanceObjects->contains($maintenanceObject)) {
            $this->maintenanceObjects[] = $maintenanceObject;
            $maintenanceObject->setVendor($this);
        }

        return $this;
    }

    public function removeMaintenanceObject(MaintenanceObject $maintenanceObject): self
    {
        if ($this->maintenanceObjects->removeElement($maintenanceObject)) {
            // set the owning side to null (unless already changed)
            if ($maintenanceObject->getVendor() === $this) {
                $maintenanceObject->setVendor(null);
            }
        }

        return $this;
    }
}