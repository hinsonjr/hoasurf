<?php

/*
 * This software is copyright to Hinson Stephens of Just Biz, Inc.
 * Please contact hinsonjr@justbiz.biz for information about the software.
 */

namespace App\Entity;

use App\Repository\DebugRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DebugRepository::class)]
class Debug
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 80)]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private $data;

    #[ORM\Column(type: 'integer', nullable: true, options: ['default' => 5])]
    private $level;

    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'log_at', type: 'date', nullable: true)]
    private $logAt;

    #[ORM\Column(type: 'datetime')]
    private $logTime;

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

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getLogAt(): ?\DateTimeImmutable
    {
        return $this->logAt;
    }

    public function setLogAt(\DateTimeImmutable $logAt): self
    {
        $this->logAt = $logAt;

        return $this;
    }

    public function getLogTime(): ?\DateTimeInterface
    {
        return $this->logTime;
    }

    public function setLogTime(\DateTimeInterface $logTime): self
    {
        $this->logTime = $logTime;

        return $this;
    }
}
