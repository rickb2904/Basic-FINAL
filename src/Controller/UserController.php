<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserTypeCoach;
use App\Form\UserTypeAdherent;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="app_users_index")
     */
    public function index(UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        if ($user->getRole() == "adherent") {
            return $this->redirectToRoute('app_adherent');
        } elseif ($user->getRole() == "coach") {
            return $this->redirectToRoute('app_coach');
        }

        $users = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/adherent", name="app_adherent")
     */
    public function adherent(): Response
    {
        return $this->render('adherent/index.html.twig');
    }

    /**
     * @Route("/coach", name="app_coach")
     */
    public function coach(): Response
    {
        return $this->render('coach/index.html.twig');
    }

    /**
     * @Route("/users/new", name="app_users_new")
     */
    public function new(Request $request): Response
    {
        $user = new User();

        if ($request->get('type') == 'adherent') {
            $form = $this->createForm(UserTypeAdherent::class, $user);
        } elseif ($request->get('type') == 'coach') {
            $form = $this->createForm(UserTypeCoach::class, $user);
        } else {
            return $this->redirectToRoute('user_list');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_list');
        }

        return $this->renderForm('user/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/users/{id}", name="app_user_show")
     */
    public function show(User $user): Response
    {
        if ($user->getRole() == "coach") {
            return $this->render('user/coach_show.html.twig', [
                'user' => $user,
            ]);
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route("/users/{id}/edit", name="app_user_edit")
     */
    public function edit(Request $request, User $user): Response

    {
        if ($user->getRole() == "adherent") {
            $form = $this->createForm(UserTypeAdherent::class, $user);
        } elseif ($user->getRole() == "coach") {
            $form = $this->createForm(UserTypeCoach::class, $user);
        } else {
            return $this->redirectToRoute('user_list');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_list');
        }

        if ($user->getRole() == "coach") {
            return $this->render('user/coach_edit.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/users/{id}/delete", name="user_delete")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_list');
    }
}