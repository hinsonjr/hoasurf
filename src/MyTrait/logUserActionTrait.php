<?php

/*
 * This software is copyright to Hinson Stephens of Just Biz, Inc.
 * Please contact hinsonjr@justbiz.biz for information about the software.
 */

namespace App\MyTrait;

/**
 * Description of AccountTrait
 *
 * @author hinso
 */
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait LogUserActionTrait
{

	/**
	 * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="creditAccount")
	 */
	protected $actionUser;

	/**
	 * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="debitAccount")
	 */
	protected $actionType;

	/**
	 * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="debitAccount")
	 */
	protected $actionChange;

	/**
	 * @return Collection|Transaction[]
	 */
	public function getCreditTransactions(): Collection
	{
		return $this->creditTransactions;
	}

	public function addCreditTransaction(Transaction $creditTransaction): self
	{
		if (!$this->creditTransactions->contains($creditTransaction))
		{
			$this->creditTransactions[] = $creditTransaction;
			$creditTransaction->setCreditAccount($this);
		}

		return $this;
	}

	public function removeCreditTransaction(Transaction $creditTransaction): self
	{
		if ($this->creditTransactions->removeElement($creditTransaction))
		{
			// set the owning side to null (unless already changed)
			if ($creditTransaction->getCreditAccount() === $this)
			{
				$creditTransaction->setCreditAccount(null);
			}
		}
		return $this;
	}

	/**
	 * @return Collection|Transaction[]
	 */
	public function getDebitTransactions(): Collection
	{
		return $this->debitTransactions;
	}

	public function addDebitTransaction(Transaction $debitTransaction): self
	{
		if (!$this->debitTransactions->contains($debitTransaction))
		{
			$this->debitTransactions[] = $debitTransaction;
			$debitTransaction->setDebitAccount($this);
		}

		return $this;
	}

	public function removeDebitTransaction(Transaction $debitTransaction): self
	{
		if ($this->debitTransactions->removeElement($debitTransaction))
		{
			// set the owning side to null (unless already changed)
			if ($debitTransaction->getDebitAccount() === $this)
			{
				$debitTransaction->setDebitAccount(null);
			}
		}

		return $this;
	}

}
