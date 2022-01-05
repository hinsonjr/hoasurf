<?php

/*
 * This software is copyright to Hinson Stephens of Just Biz, Inc.
 * Please contact hinsonjr@justbiz.biz for information about the software.
 */

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Description of AccessDeniedHandler
 *
 * @author hinso
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
	public function __construct(Security $security)
	{
		$this->security = $security;
	}	
	
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        // ...
		//$attrs = $this->getAttributes();
		//var_dump($attrs);
		var_dump($this->security->getUser()->getRoles());
        return new Response("Hum - something aint right", 403);
    }
}
