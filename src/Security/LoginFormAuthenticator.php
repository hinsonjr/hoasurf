<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
		$user = $token->getUser();
		$roles = $user->getRoles();
		$targetPath = $this->getTargetPath($request->getSession(), $firewallName);
		if (empty($targetPath))
		{
			$targetPath = $this->getRolePath($roles[0]);
		}

		if (count($user->getRoles()) > 1 || $user->getRoles()[0] !== "ROLE_USER")
		{
			if (!$user->getActiveHoa())
			{
				return new RedirectResponse($this->urlGenerator->generate('user_select_hoa',['target' => $targetPath]));
			}
		}
		return new RedirectResponse($targetPath);
    }

	private function getRolePath($role): string
	{
		switch ($role)
		{
			case 'ROLE_SUPER_ADMIN':
				return $this->urlGenerator->generate('admin_dash');
				break;
			case 'ROLE_HOA_OWNER':
				return $this->urlGenerator->generate('owner_dash');
				break;
			case 'ROLE_HOA_ACCOUNTING':
				return $this->urlGenerator->generate('accounting_dash');
				break;
			default:
				return $this->urlGenerator->generate('home');
				break;
		}		
	}
	
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
