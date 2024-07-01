<?php

namespace App\Entity;

use App\Repository\RequestStatusRepository;
use App\Repository\RequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequestRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Request
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'requests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RequestType $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdDate = null;

    #[ORM\ManyToOne(inversedBy: 'requests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'requests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $assignedTo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $completedDate = null;

    #[ORM\ManyToOne(inversedBy: 'completedRequests')]
    private ?User $completedBy = null;

    #[ORM\ManyToOne(inversedBy: 'requests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RequestStatus $status = null;

    #[ORM\OneToMany(mappedBy: 'request', targetEntity: RequestNote::class, orphanRemoval: true)]
    private Collection $notes;

    #[ORM\ManyToOne(inversedBy: 'requests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hoa $hoa = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\ManyToOne(inversedBy: 'requests')]
    private ?Building $building = null;

    #[ORM\ManyToOne(inversedBy: 'requests')]
    private ?Unit $unit = null;

    #[ORM\ManyToOne(inversedBy: 'requests')]
    private ?Vendor $vendor = null;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function initValues()
    {
        $this->createdDate = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?RequestType
    {
        return $this->type;
    }

    public function setType(?RequestType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getAssignedTo(): ?User
    {
        return $this->assignedTo;
    }

    public function setAssignedTo(?User $assignedTo): self
    {
        $this->assignedTo = $assignedTo;

        return $this;
    }

    public function getCompletedDate(): ?\DateTimeInterface
    {
        return $this->completedDate;
    }

    public function setCompletedDate(?\DateTimeInterface $completedDate): self
    {
        $this->completedDate = $completedDate;

        return $this;
    }

    public function getCompletedBy(): ?User
    {
        return $this->completedBy;
    }

    public function setCompletedBy(?User $completedBy): self
    {
        $this->completedBy = $completedBy;

        return $this;
    }

    public function getStatus(): ?RequestStatus
    {
        return $this->status;
    }

    public function setStatus(?RequestStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, RequestNote>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(RequestNote $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setRequest($this);
        }

        return $this;
    }

    public function removeNote(RequestNote $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getRequest() === $this) {
                $note->setRequest(null);
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

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;

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

    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    public function setVendor(?Vendor $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }
}
