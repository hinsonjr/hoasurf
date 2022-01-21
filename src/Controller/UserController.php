<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\HOA;
use App\Repository\HOARepository;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

	
    #[Route('/selecthoa', name: 'user_select_hoa', methods: ['GET', 'POST'])]
    public function selectHoa($target = "", Request $request, UserRepository $userRepository, EntityManagerInterface $em, HOARepository $hoaRepo): Response
    {
		if ($target == "")
		{
			$target = $_REQUEST['target'];
		}
		$user = $this->getUser();
		if (in_array('ROLE_SUPER_ADMIN', $user->getRoles()))
		{
			$userHoas = $hoaRepo->findAll();
		}
		else if (in_array('ROLE_HOA_ACCOUNTING', $user->getRoles()))
		{
			$userHoas = $hoaRepo->findAll();
		}
		else
		{
			$userHoas = $userRepository->findUserHoas($user);
		}
		$form = $this->createFormBuilder($user)
			->add('activeHoa', EntityType::class, [
				'class' => HOA::class,
				'choices' => $userHoas])
            ->add('save', SubmitType::class, ['label' => 'Set Active HOA'])
            ->getForm();		
		$form->handleRequest($request);
        if ($form->isSubmitted()) {
			$hoa = $form->get('activeHoa')->getData();
			$user->setActiveHoa($hoa);
			
			if ($user->getActiveHoa())
			{
				$em->persist($user);
				$em->flush();
				if ($target)
				{
					return new RedirectResponse($target);
				}				
				return $this->redirectToRoute('home');
			}
			else
			{
				// if no HOA is defined, send user HOME
				return $this->redirectToRoute('home');
			}
		}
		$error = false;
		if (count($userHoas) < 1)
		{
			$error = "User does not belong to any HOAs";
		}
        return $this->renderForm('hoa/select.html.twig', [
            'hoas' => $userHoas,
			'form' => $form,
			'active_hoa' => $user->getActiveHoa(),
			'error' => $error,
        ]);
	}

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}
