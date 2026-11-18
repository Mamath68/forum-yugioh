<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\RegistrationFormType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserController extends AbstractController
{
    #[Route("/admin/users", name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAllExcept($user),
            "title" => "Liste des utilisateurs "

        ]);
    }

    #[Route('user/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
            "title" => "Profile de : " . $user->getUsername()
        ]);
    }

    #[Route('user/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request                     $request,
        User                        $user,
        EntityManagerInterface      $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $user, [
            'is_edit' => true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            if (!empty($plainPassword)) {
                $user->setPassword(
                    $passwordHasher->hashPassword($user, $plainPassword)
                );
            }

            $entityManager->flush();

            return $this->redirectToRoute(
                'app_user_index',
                [],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            "title"=>"Edition du compte de:" . $user->getUsername()
        ]);
    }

    #[Route('user/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
