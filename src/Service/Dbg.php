<?php

/*
 * This software is copyright to Hinson Stephens of Just Biz, Inc.
 * Please contact hinsonjr@justbiz.biz for information about the software.
 */

namespace App\Service;

use App\Entity\Debug;
use App\Service\Settings;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of Debug
 *
 * @author hinso
 */


class Dbg
{
	private $em = null;
	
	public function __construct(EntityManagerInterface $em, Settings $settings)
	{
		$this->em = $em;
		$this->settings = $settings;
	}
	
	public function dump($var,$prefix = "DUMP:")
	{
		return "<br>$prefix<pre>".json_encode($var,JSON_PRETTY_PRINT) . "</pre><br>";
	}
	
	public function log($name, $data, $level): Response
	{
		$debugRepo = $this->em->getRepository(Debug::class);
		$debugLevel = $this->settings->get('debugLevel');
		if ($level <= $debugLevel)
		{
			$debug = new Debug();
			$debug->setName($name);
			$type = gettype($data);
			if (is_array($data) || is_object($data))
			{
				$data = json_encode($data,JSON_PRETTY_PRINT|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_INVALID_UTF8_IGNORE);
			}
			$data = "(" . $type . ") " . $data;
			$debug->setData($data);
			$debug->setLevel($level);
			$debug->setLogTime(new \DateTime());
			$debugRepo = $this->em->getRepository(Debug::class);			
			$this->em->persist($debug);
			$this->em->flush();
		}
		return new Response("Saved Log");
	}
}
