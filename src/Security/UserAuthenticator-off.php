<?php

/*
 * This software is copyright to Hinson Stephens of Just Biz, Inc.
 * Please contact hinsonjr@justbiz.biz for information about the software.
 */

namespace App\Security;

/**
 * Description of UserAuthenticator
 *
 * @author hinso
 */
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Bundle\SecurityBundle\Security\FirewallAwareTrait;
use Symfony\Bundle\SecurityBundle\Security\FirewallMapInterface;

/**
 * A decorator that delegates all method calls to the authenticator
 * manager of the current firewall.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 *
 * @final
 */
class UserAuthenticator implements UserAuthenticatorInterface
{

	use FirewallAwareTrait;

	public function __construct(ContainerInterface $userAuthenticators, RequestStack $requestStack)
	{
		// $this->firewallMap = $firewallMap;
		$this->requestStack = $requestStack;
	}

	public function supports(Request $request): ?bool
    {
        return true;
    }
	
	public function onAuthenticationSuccess(Request $request, TokenInterface $token)
	{
		if ($this->security->isGranted('ROLE_SUPER_ADMIN'))
		{
			$response = new RedirectResponse($this->router->generate('admin_dash'));
		} elseif ($this->security->isGranted('ROLE_HOA_OWNER'))
		{
			$response = new RedirectResponse($this->router->generate('owner_dash'));
		} elseif ($this->security->isGranted('ROLE_USER'))
		{
			// redirect the user to where they were before the login process begun. 
			$referer_url = $request->headers->get('referer');
			if (!$referer_url)
			{
				new RedirectResponse($this->router->generate('home'));
			}
			$response = new RedirectResponse($referer_url);
		}

		return $response;
	}

	/**
	 * {@inheritdoc}
	 */
	public function authenticateUser(UserInterface $user, AuthenticatorInterface $authenticator, Request $request, array $badges = []): ?Response
	{
		return $this->getForFirewall()->authenticateUser($user, $authenticator, $request, $badges);
	}

}
