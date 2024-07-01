<?php

namespace App\Entity;

use App\Entity\Accounting\LedgerAccount;
use App\Repository\VendorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VendorRepository::class)]
class Vendor
{

	#[ORM\Id]
               	#[ORM\GeneratedValue]
               	#[ORM\Column(type: "integer")]
               	private $id;

	#[ORM\Column(type: "string", length: 255)]
               	private $name;

	#[ORM\Column(type: "string", length: 255, nullable: true)]
               	private $contactName;

	#[ORM\Column(type: "string", length: 20)]
               	private $contactNumber;

	#[ORM\Column(type: "string", length: 255, nullable: true)]
               	private $contactEmail;

	#[ORM\Column(type: "string", length: 255, nullable: true)]
               	private $type;

	#[ORM\Column(type: "text", nullable: true)]
               	private $description;

	#[ORM\OneToMany(targetEntity: MaintenanceObject::class, mappedBy: "vendor")]
               	private $maintenanceObjects;

	#[ORM\OneToMany(targetEntity: LedgerAccount::class, mappedBy: "vendor")]
               	private $ledgerAccounts;

	#[ORM\ManyToOne(inversedBy: 'vendors')]
               	private ?Hoa $hoa = null;

    #[ORM\OneToMany(mappedBy: 'vendor', targetEntity: Request::class)]
    private Collection $requests;

	public function __construct()
               	{
               		$this->maintenanceObjects = new ArrayCollection();
               		$this->ledgerAccounts = new ArrayCollection();
                 $this->requests = new ArrayCollection();
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

//    @return Collection|MaintenanceObject[]
	public function getMaintenanceObjects(): Collection
               	{
               		return $this->maintenanceObjects;
               	}

	public function addMaintenanceObject(MaintenanceObject $maintenanceObject): self
               	{
               		if (!$this->maintenanceObjects->contains($maintenanceObject))
               		{
               			$this->maintenanceObjects[] = $maintenanceObject;
               			$maintenanceObject->setVendor($this);
               		}
               
               		return $this;
               	}

	public function removeMaintenanceObject(MaintenanceObject $maintenanceObject): self
               	{
               		if ($this->maintenanceObjects->removeElement($maintenanceObject))
               		{
               			// set the owning side to null (unless already changed)
               			if ($maintenanceObject->getVendor() === $this)
               			{
               				$maintenanceObject->setVendor(null);
               			}
               		}
               
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
               			$ledgerAccount->setVendor($this);
               		}
               
               		return $this;
               	}

	public function removeLedgerAccount(LedgerAccount $ledgerAccount): self
               	{
               		if ($this->ledgerAccounts->removeElement($ledgerAccount))
               		{
               			// set the owning side to null (unless already changed)
               			if ($ledgerAccount->getVendor() === $this)
               			{
               				$ledgerAccount->setVendor(null);
               			}
               		}
               
               		return $this;
               	}

	public function getHoa(): ?Hoa
               	{
               		return $this->hoa;
               	}

	public function setHoa(?Hoa $hoa): self
               	{
               		$this->hoa = $hoa;
               
               		return $this;
               	}

    /**
     * @return Collection<int, Request>
     */
    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(Request $request): self
    {
        if (!$this->requests->contains($request)) {
            $this->requests->add($request);
            $request->setVendor($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->removeElement($request)) {
            // set the owning side to null (unless already changed)
            if ($request->getVendor() === $this) {
                $request->setVendor(null);
            }
        }

        return $this;
    }

}
