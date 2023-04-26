<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{

	#[ORM\Id]
               	#[ORM\GeneratedValue]
               	#[ORM\Column(type: "integer")]
               	private $id;

	#[ORM\Column(type: "string", length: 255)]
               	private $name;

	#[ORM\Column(type: "string", length: 255)]
               	private $roleName;

	#[ORM\Column(type: "boolean")]
               	private $status;

	#[ORM\ManyToMany(targetEntity: User::class, mappedBy: "roles")]
               	private $users;

    #[ORM\OneToMany(mappedBy: 'target', targetEntity: Message::class)]
    private Collection $messages;

	public function __construct()
               	{
               		$this->users = new ArrayCollection();
                 $this->messages = new ArrayCollection();
               	}

	public function __toString()
               	{
               		return $this->getName();
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

	public function getRoleName(): ?string
               	{
               		return $this->roleName;
               	}

	public function setRoleName(string $roleName): self
               	{
               		$this->roleName = $roleName;
               
               		return $this;
               	}

	public function getStatus(): ?bool
               	{
               		return $this->status;
               	}

	public function setStatus(bool $status): self
               	{
               		$this->status = $status;
               		return $this->status;
               	}

//    @return Collection|User[]
	public function getUsers(): Collection
               	{
               		return $this->users;
               	}

	public function addUser(User $user): self
               	{
               		if (!$this->users->contains($user))
               		{
               			$this->users[] = $user;
               			$user->addRole($this);
               		}
               
               		return $this;
               	}

	public function removeUser(User $user): self
               	{
               		if ($this->users->removeElement($user))
               		{
               			$user->removeRole($this);
               		}
               
               		return $this;
               	}

	public function getMessage(): ?Message
               	{
               		return $this->message;
               	}

	public function setMessage(Message $message): self
               	{
               		// set the owning side of the relation if necessary
               		if ($message->getTarget() !== $this)
               		{
               			$message->setTarget($this);
               		}
               
               		$this->message = $message;
               
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
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setTarget($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getTarget() === $this) {
                $message->setTarget(null);
            }
        }

        return $this;
    }

}
