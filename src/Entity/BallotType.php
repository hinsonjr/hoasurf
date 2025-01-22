<?php

namespace App\Entity;

use App\Repository\BallotTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BallotTypeRepository::class)]
class BallotType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Ballot::class)]
    private Collection $ballots;

    public function __construct()
    {
        $this->ballots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Ballot>
     */
    public function getBallots(): Collection
    {
        return $this->ballots;
    }

    public function addBallot(Ballot $ballot): self
    {
        if (!$this->ballots->contains($ballot)) {
            $this->ballots->add($ballot);
            $ballot->setType($this);
        }

        return $this;
    }

    public function removeBallot(Ballot $ballot): self
    {
        if ($this->ballots->removeElement($ballot)) {
            // set the owning side to null (unless already changed)
            if ($ballot->getType() === $this) {
                $ballot->setType(null);
            }
        }

        return $this;
    }
}
