<?php

namespace App\Entity;

use App\Entity\Accounting\Transaction;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=180, unique=true)
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $name;

	/**
	 * @ORM\ManyToMany(targetEntity=Role::class, inversedBy="users")
	 */
	private $roles = [];

	/**
	 * @var string The hashed password
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $password;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $isVerified = false;

	/**
	 * @ORM\OneToMany(targetEntity=Owner::class, mappedBy="user")
	 */
	private $owners;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $lastLogin;

    /**
     * @ORM\ManyToOne(targetEntity=Hoa::class)
     */
    private $activeHoa;

	public function __construct()
         	{
         		$this->owners = new ArrayCollection();
         		$this->roles = new ArrayCollection();
         	}

	public function __toString()
         	{
         		return $this->getName();
         	}

	public function getId(): ?int
         	{
         		return $this->id;
         	}

	public function getEmail(): ?string
         	{
         		return $this->email;
         	}

	public function setEmail(string $email): self
         	{
         		$this->email = $email;
         
         		return $this;
         	}

	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUserIdentifier(): string
         	{
         		return (string) $this->email;
         	}

	/**
	 * @see UserInterface
	 */
	public function getRoles(): array
         	{
         		$userRoles = $this->roles;
         		// guarantee every user at least has ROLE_USER
         		$roles = [];
         		foreach ($userRoles as $userRole)
         		{
         			$roles[] = $userRole->getRoleName();
         		}
         		if (empty($roles))
         		{
         			$roles[] = "ROLE_USER";
         		}
         		return array_unique($roles);
         	}

	/* public function setRoles(array $roles): self
	  {
	  $this->roles = $roles;

	  return $this;
	  }
	 * 
	 */

	/**
	 * @see PasswordAuthenticatedUserInterface
	 */
	public function getPassword(): string
         	{
         		return $this->password;
         	}

	public function setPassword(string $password): self
         	{
         		$this->password = $password;
         
         		return $this;
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
	 * @see UserInterface
	 */
	public function eraseCredentials()
         	{
         		// If you store any temporary, sensitive data on the user, clear it here
         		// $this->plainPassword = null;
         	}

	public function isVerified(): bool
         	{
         		return $this->isVerified;
         	}

	public function setIsVerified(bool $isVerified): self
         	{
         		$this->isVerified = $isVerified;
         
         		return $this;
         	}

	/**
	 * @return Collection|Owner[]
	 */
	public function getOwners(): Collection
         	{
         		return $this->owners;
         	}

	public function addOwner(Owner $owner): self
         	{
         		if (!$this->owners->contains($owner))
         		{
         			$this->owners[] = $owner;
         			$owner->setUser($this);
         		}
         
         		return $this;
         	}

	public function removeOwner(Owner $owner): self
         	{
         		if ($this->owners->removeElement($owner))
         		{
         			// set the owning side to null (unless already changed)
         			if ($owner->getUser() === $this)
         			{
         				$owner->setUser(null);
         			}
         		}
         
         		return $this;
         	}

	public function getLastLogin(): ?\DateTimeInterface
         	{
         		return $this->lastLogin;
         	}

	public function setLastLogin(?\DateTimeInterface $lastLogin): self
         	{
         		$this->lastLogin = $lastLogin;
         
         		return $this;
         	}

    public function getActiveHoa(): ?Hoa
    {
        return $this->activeHoa;
    }

    public function setActiveHoa(?Hoa $activeHoa): self
    {
        $this->activeHoa = $activeHoa;

        return $this;
    }

}
