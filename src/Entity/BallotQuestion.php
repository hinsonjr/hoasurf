<?php

namespace App\Entity;

use App\Repository\BallotQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BallotQuestionRepository::class)]
class BallotQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'ballotQuestion', targetEntity: ballotAnswer::class)]
    private Collection $answers;

    #[ORM\ManyToOne(inversedBy: 'question')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ballot $ballot = null;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
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

    /**
     * @return Collection<int, ballotAnswer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(ballotAnswer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setBallotQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(ballotAnswer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getBallotQuestion() === $this) {
                $answer->setBallotQuestion(null);
            }
        }

        return $this;
    }

    public function getBallot(): ?Ballot
    {
        return $this->ballot;
    }

    public function setBallot(?Ballot $ballot): self
    {
        $this->ballot = $ballot;

        return $this;
    }
}
