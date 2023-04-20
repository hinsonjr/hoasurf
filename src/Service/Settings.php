<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface as EntityManagerInterface;
use App\Entity\Setting;

class Settings
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
		$this->repo = $this->em->getRepository(Setting::class);
	}
	
	public function get($name)
	{
		$setting = $this->repo->findOneByName($name);
		if ($setting === null)
		{
			return null;
		}
		return $setting->getValue();
	}

	public function set($name, $value)
	{
		$repo =  $this->em->getRepository(Setting::class);
		$setting = $repo->findOneByName($name);
		if ($setting)
		{
			$setting->setValue($value);
		}
		else
		{
			$ent = new SettingEntity();
			$ent->setName($name);
			$ent->setValue($value);
			$entityManager->persist($debug);
			$entityManager->flush();			
		}
	}
}
