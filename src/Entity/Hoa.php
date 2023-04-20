<?php

namespace App\Entity;

use App\Entity\Accounting\LedgerAccount;
use App\Repository\HoaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HoaRepository::class)
 */
class Hoa
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
    private $shortName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $adminName;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $adminPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adminEmail;

    /**
     * @ORM\OneToMany(targetEntity=Building::class, mappedBy="hoa")
     */
    private $buildings;

    /**
     * @ORM\OneToMany(targetEntity=MaintenanceObject::class, mappedBy="hoa")
     */
    private $maintenanceObjects;

    /**
     * @ORM\OneToMany(targetEntity=LedgerAccount::class, mappedBy="hoa")
     */
    private $ledgerAccounts;

    public function __construct()
    {
        $this->buildings = new ArrayCollection();
        $this->maintenanceObjects = new ArrayCollection();
        $this->ledgerAccounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getName();
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

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(?string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getAdminName(): ?string
    {
        return $this->adminName;
    }

    public function setAdminName(string $adminName): self
    {
        $this->adminName = $adminName;

        return $this;
    }

    public function getAdminPhone(): ?string
    {
        return $this->adminPhone;
    }

    public function setAdminPhone(?string $adminPhone): self
    {
        $this->adminPhone = $adminPhone;

        return $this;
    }

    public function getAdminEmail(): ?string
    {
        return $this->adminEmail;
    }

    public function setAdminEmail(?string $adminEmail): self
    {
        $this->adminEmail = $adminEmail;

        return $this;
    }

    /**
     * @return Collection|Building[]
     */
    public function getBuildings(): Collection
    {
        return $this->buildings;
    }

    public function addBuilding(Building $building): self
    {
        if (!$this->buildings->contains($building)) {
            $this->buildings[] = $building;
            $building->setHoa($this);
        }

        return $this;
    }

    public function removeBuilding(Building $building): self
    {
        if ($this->buildings->removeElement($building)) {
            // set the owning side to null (unless already changed)
            if ($building->getHoa() === $this) {
                $building->setHoa(null);
            }
        }

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
            $maintenanceObject->setHoa($this);
        }

        return $this;
    }

    public function removeMaintenanceObject(MaintenanceObject $maintenanceObject): self
    {
        if ($this->maintenanceObjects->removeElement($maintenanceObject)) {
            // set the owning side to null (unless already changed)
            if ($maintenanceObject->getHoa() === $this) {
                $maintenanceObject->setHoa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LedgerAccount[]
     */
    public function getLedgerAccounts(): Collection
    {
        return $this->ledgerAccounts;
    }

    public function addLedgerAccount(LedgerAccount $ledgerAccount): self
    {
        if (!$this->ledgerAccounts->contains($ledgerAccount)) {
            $this->ledgerAccounts[] = $ledgerAccount;
            $ledgerAccount->setHoa($this);
        }

        return $this;
    }

    public function removeLedgerAccount(LedgerAccount $ledgerAccount): self
    {
        if ($this->ledgerAccounts->removeElement($ledgerAccount)) {
            // set the owning side to null (unless already changed)
            if ($ledgerAccount->getHoa() === $this) {
                $ledgerAccount->setHoa(null);
            }
        }

        return $this;
    }
}
