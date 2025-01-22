<?php

namespace App\Entity;

use App\Repository\BallotTargetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BallotTargetRepository::class)]
class BallotTarget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'target', targetEntity: Ballot::class)]
    private Collection $ballots;

    public function __construct()
    {
        $this->ballots = new ArrayCollection();
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
            $ballot->setTarget($this);
        }

        return $this;
    }

    public function removeBallot(Ballot $ballot): self
    {
        if ($this->ballots->removeElement($ballot)) {
            // set the owning side to null (unless already changed)
            if ($ballot->getTarget() === $this) {
                $ballot->setTarget(null);
            }
        }

        return $this;
    }
}
