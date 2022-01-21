<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController {
	#[Route('/login', name: 'login')]

	public function index(AuthenticationUtils $authenticationUtils): Response {
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render('login/index.html.twig', [
				'last_username' => $lastUsername,
				'error' => $error,
		]);
	}
	
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
		$user = $token->getUser();
		if ($user->isGranted('ROLE_SUPER_ADMIN'))
		{
			return new RedirectResponse($this->router->generate('admin_dash'));
		}
        return null;
    }	

}
