<?php

namespace App\Entity;

use App\Repository\MessageCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageCategoryRepository::class)]
class MessageCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $category = null;

    #[ORM\ManyToOne(inversedBy: 'messageCategories')]
    private ?Hoa $hoa = null;

    public function getId(): ?int
    {
        return $this->id;
    }
	
    public function __toString(): string
    {
        return $this->category;
    }
    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getHoa(): ?Hoa
    {
        return $this->hoa;
    }

    public function setHoa(?Hoa $hoa): self
    {
        $this->hoa = $hoa;

        return $this;
    }
}
