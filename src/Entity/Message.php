<?php

namespace App\Entity;

use DateTime;
use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\PostPersistEventArgs;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Message
{

//	use TimestampableEntity;
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	private ?string $subject = null;

	#[ORM\Column(type: Types::TEXT)]
	private ?string $body = null;

	#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
	private ?\DateTimeInterface $expiration = null;

	#[ORM\ManyToOne(inversedBy: 'messages')]
	#[ORM\JoinColumn(nullable: false)]
	private ?MessageType $type = null;

	#[ORM\ManyToOne(inversedBy: 'messages')]
	#[ORM\JoinColumn(nullable: false)]
	private ?MessageCategory $category = null;

	#[ORM\ManyToOne(inversedBy: 'messages')]
	#[ORM\JoinColumn(nullable: false)]
	private ?User $createdBy = null;

	#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
	protected ?\DateTimeInterface $createdAt = null;

	#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
	protected ?\DateTimeInterface $updatedAt = null;

	#[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
	private ?self $parent = null;

	#[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
	private Collection $messages;

	public function __construct()
	{
		$this->messages = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
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

	public function getBody(): ?string
	{
		return $this->body;
	}

	public function setBody(string $body): self
	{
		$this->body = $body;

		return $this;
	}

	public function getExpiration(): ?\DateTimeInterface
	{
		return $this->expiration;
	}

	public function setExpiration(?\DateTimeInterface $expiration): self
	{
		$this->expiration = $expiration;

		return $this;
	}

	public function getType(): ?MessageType
	{
		return $this->type;
	}

	public function setType(?MessageType $type): self
	{
		$this->type = $type;

		return $this;
	}

	public function getCategory(): ?MessageCategory
	{
		return $this->category;
	}

	public function setCategory(?MessageCategory $category): self
	{
		$this->category = $category;

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

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt(): DateTime
	{
		return $this->createdAt;
	}

	/**
	 * @param \DateTime $createdAt
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt(): DateTime
	{
		return $this->updatedAt;
	}

	/**
	 * @param \DateTime $updatedAt
	 */
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;
	}

	#[ORM\PrePersist]
	#[ORM\PreUpdate]
	public function updatedTimestamps()
	{
		$this->setUpdatedAt(new \DateTime('now'));

		if ($this->getCreatedAt() == null)
		{
			$this->setCreatedAt(new \DateTime('now'));
		}
	}

	public function getParent(): ?self
	{
		return $this->parent;
	}

	public function setParent(?self $parent): self
	{
		$this->parent = $parent;

		return $this;
	}

	/**
	 * @return Collection<int, self>
	 */
	public function getMessages(): Collection
	{
		return $this->messages;
	}

	public function addMessage(self $message): self
	{
		if (!$this->messages->contains($message))
		{
			$this->messages->add($message);
			$message->setParent($this);
		}

		return $this;
	}

	public function removeMessage(self $message): self
	{
		if ($this->messages->removeElement($message))
		{
			// set the owning side to null (unless already changed)
			if ($message->getParent() === $this)
			{
				$message->setParent(null);
			}
		}

		return $this;
	}

}
