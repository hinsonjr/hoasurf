<?php

namespace App\Entity;

use App\Entity\Accounting\HoaReportCategory;
use App\Entity\Accounting\LedgerAccount;
use App\Repository\HoaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoaRepository::class)]
class Hoa
{

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private $id;

	#[ORM\Column(type: "string", length: 255)]
	private $name;

	#[ORM\Column(type: "string", length: 255, nullable: true)]
	private $shortName;

	#[ORM\Column(type: "string", length: 100)]
	private $adminName;

	#[ORM\Column(type: "string", length: 128, nullable: true)]
	private $adminPhone;

	#[ORM\Column(type: "string", length: 255, nullable: true)]
	private $adminEmail;

	#[ORM\OneToMany(targetEntity: Building::class, mappedBy: "hoa")]
	private $buildings;

	#[ORM\OneToMany(targetEntity: MaintenanceObject::class, mappedBy: "hoa")]
	private $maintenanceObjects;

	#[ORM\OneToMany(targetEntity: LedgerAccount::class, mappedBy: "hoa")]
	private $ledgerAccounts;

	#[ORM\OneToMany(mappedBy: 'hoa', targetEntity: HoaReportCategory::class)]
	private Collection $hoaReportCategories;

	#[ORM\OneToMany(mappedBy: 'hoa', targetEntity: Message::class)]
	private Collection $messages;

	#[ORM\OneToMany(mappedBy: 'hoa', targetEntity: MessageCategory::class)]
	private Collection $messageCategories;

	#[ORM\OneToMany(mappedBy: 'hoa', targetEntity: Vendor::class)]
	private Collection $vendors;

	public function __construct()
	{
		$this->buildings = new ArrayCollection();
		$this->maintenanceObjects = new ArrayCollection();
		$this->ledgerAccounts = new ArrayCollection();
		$this->hoaReportCategories = new ArrayCollection();
		$this->messages = new ArrayCollection();
		$this->messageCategories = new ArrayCollection();
		$this->vendors = new ArrayCollection();
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

//    @return Collection|Building[]
	public function getBuildings(): Collection
	{
		return $this->buildings;
	}

	public function addBuilding(Building $building): self
	{
		if (!$this->buildings->contains($building))
		{
			$this->buildings[] = $building;
			$building->setHoa($this);
		}

		return $this;
	}

	public function removeBuilding(Building $building): self
	{
		if ($this->buildings->removeElement($building))
		{
			// set the owning side to null (unless already changed)
			if ($building->getHoa() === $this)
			{
				$building->setHoa(null);
			}
		}

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
			$maintenanceObject->setHoa($this);
		}

		return $this;
	}

	public function removeMaintenanceObject(MaintenanceObject $maintenanceObject): self
	{
		if ($this->maintenanceObjects->removeElement($maintenanceObject))
		{
			// set the owning side to null (unless already changed)
			if ($maintenanceObject->getHoa() === $this)
			{
				$maintenanceObject->setHoa(null);
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
			$ledgerAccount->setHoa($this);
		}

		return $this;
	}

	public function removeLedgerAccount(LedgerAccount $ledgerAccount): self
	{
		if ($this->ledgerAccounts->removeElement($ledgerAccount))
		{
			// set the owning side to null (unless already changed)
			if ($ledgerAccount->getHoa() === $this)
			{
				$ledgerAccount->setHoa(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection<int, HoaReportCategory>
	 */
	public function getHoaReportCategories(): Collection
	{
		return $this->hoaReportCategories;
	}

	public function addHoaReportCategory(HoaReportCategory $hoaReportCategory): self
	{
		if (!$this->hoaReportCategories->contains($hoaReportCategory))
		{
			$this->hoaReportCategories->add($hoaReportCategory);
			$hoaReportCategory->setHoa($this);
		}

		return $this;
	}

	public function removeHoaReportCategory(HoaReportCategory $hoaReportCategory): self
	{
		if ($this->hoaReportCategories->removeElement($hoaReportCategory))
		{
			// set the owning side to null (unless already changed)
			if ($hoaReportCategory->getHoa() === $this)
			{
				$hoaReportCategory->setHoa(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection<int, Message>
	 */
	public function getMessages(): Collection
	{
		return $this->messages;
	}

	public function addMessage(Message $message): self
	{
		if (!$this->messages->contains($message))
		{
			$this->messages->add($message);
			$message->setHoa($this);
		}

		return $this;
	}

	public function removeMessage(Message $message): self
	{
		if ($this->messages->removeElement($message))
		{
			// set the owning side to null (unless already changed)
			if ($message->getHoa() === $this)
			{
				$message->setHoa(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection<int, MessageCategory>
	 */
	public function getMessageCategories(): Collection
	{
		return $this->messageCategories;
	}

	public function addMessageCategory(MessageCategory $messageCategory): self
	{
		if (!$this->messageCategories->contains($messageCategory))
		{
			$this->messageCategories->add($messageCategory);
			$messageCategory->setHoa($this);
		}

		return $this;
	}

	public function removeMessageCategory(MessageCategory $messageCategory): self
	{
		if ($this->messageCategories->removeElement($messageCategory))
		{
			// set the owning side to null (unless already changed)
			if ($messageCategory->getHoa() === $this)
			{
				$messageCategory->setHoa(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection<int, Vendor>
	 */
	public function getVendors(): Collection
	{
		return $this->vendors;
	}

	public function addVendor(Vendor $vendor): self
	{
		if (!$this->vendors->contains($vendor))
		{
			$this->vendors->add($vendor);
			$vendor->setHoa($this);
		}

		return $this;
	}

	public function removeVendor(Vendor $vendor): self
	{
		if ($this->vendors->removeElement($vendor))
		{
			// set the owning side to null (unless already changed)
			if ($vendor->getHoa() === $this)
			{
				$vendor->setHoa(null);
			}
		}

		return $this;
	}

}
