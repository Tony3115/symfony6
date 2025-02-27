<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Event\UserAddSuccessEvent;
use App\Repository\UserRepository;
use App\Event\UserDeleteSuccessEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(EventDispatcherInterface $dispatcher, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $form->get('password')->getData();
            if ($password) {
                $encoded = $encoder->hashPassword($user, $password);
                $user->setPassword($encoded);
            }

            $params = $request->request->all();
            if (isset($params['user']) && isset($params['user']['roles'])) {
                $roles = $params['user']['roles'];
                $user->setRoles([$roles]);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Produit ajouté avec succès');
            // avertir via email du succès d'ajout avec un dispatch
            $userEvent = new UserAddSuccessEvent($user);
            $dispatcher->dispatch($userEvent, 'userAdd.success');

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $encoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $form->get('password')->getData();
            if ($password) {
                $encoded = $encoder->hashPassword($user, $password);
                $user->setPassword($encoded);
            }
            $params = $request->request->all();


            if (isset($params['user']) && isset($params['user']['roles'])) {
                $roles = $params['user']['roles'];
                $user->setRoles([$roles]);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(EventDispatcherInterface $dispatcher, Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();

            //dispatcher l'évènement userDelete.success
            $userEvent = new UserDeleteSuccessEvent($user);

            $dispatcher->dispatch($userEvent, 'userDelete.success');
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
