<?php

namespace App\Entity;

use App\Repository\RequestTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequestTypeRepository::class)]
class RequestType
{

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 32)]
	private ?string $type = null;

	#[ORM\OneToMany(mappedBy: 'type', targetEntity: Request::class)]
	private Collection $requests;

	public function __construct()
	{
		$this->requests = new ArrayCollection();
	}

	public function __toString()
	{
		return $this->getType();
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
	 * @return Collection<int, Request>
	 */
	public function getRequests(): Collection
	{
		return $this->requests;
	}

	public function addRequest(Request $request): self
	{
		if (!$this->requests->contains($request))
		{
			$this->requests->add($request);
			$request->setType($this);
		}

		return $this;
	}

	public function removeRequest(Request $request): self
	{
		if ($this->requests->removeElement($request))
		{
			// set the owning side to null (unless already changed)
			if ($request->getType() === $this)
			{
				$request->setType(null);
			}
		}

		return $this;
	}

}
