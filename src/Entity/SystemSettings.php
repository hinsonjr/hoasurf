<?php

namespace App\Entity;

use App\Repository\SystemSettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SystemSettingsRepository::class)]
class SystemSettings
{

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private $id;

	#[ORM\Column(type: "string", length: 255)]
	private $name;

	#[ORM\Column(type: "string", length: 255, nullable: true)]
	private $value;

	#[ORM\Column(type: "datetime")]
	private $lastUpdate;

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

	public function getValue(): ?string
	{
		return $this->value;
	}

	public function setValue(?string $value): self
	{
		$this->value = $value;

		return $this;
	}

	public function getLastUpdate(): ?\DateTimeInterface
	{
		return $this->lastUpdate;
	}

	public function setLastUpdate(\DateTimeInterface $lastUpdate): self
	{
		$this->lastUpdate = $lastUpdate;

		return $this;
	}

}
