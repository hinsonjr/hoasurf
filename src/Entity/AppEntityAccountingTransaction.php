<?php

namespace App\Entity;

use App\Repository\AppEntityAccountingTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppEntityAccountingTransactionRepository::class)
 */
class AppEntityAccountingTransaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
