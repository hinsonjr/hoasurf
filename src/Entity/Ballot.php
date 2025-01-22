<?php

namespace App\Entity;

use App\Repository\BallotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BallotRepository::class)]
class Ballot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'ballots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ballotTarget $target = null;

    #[ORM\ManyToOne(inversedBy: 'ballots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ballotType $type = null;

    #[ORM\OneToMany(mappedBy: 'ballot', targetEntity: ballotQuestion::class)]
    private Collection $question;

    public function __construct()
    {
        $this->question = new ArrayCollection();
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

    public function getTarget(): ?ballotTarget
    {
        return $this->target;
    }

    public function setTarget(?ballotTarget $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getType(): ?ballotType
    {
        return $this->type;
    }

    public function setType(?ballotType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, ballotQuestion>
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(ballotQuestion $question): self
    {
        if (!$this->question->contains($question)) {
            $this->question->add($question);
            $question->setBallot($this);
        }

        return $this;
    }

    public function removeQuestion(ballotQuestion $question): self
    {
        if ($this->question->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getBallot() === $this) {
                $question->setBallot(null);
            }
        }

        return $this;
    }
}
