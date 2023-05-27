<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserTypeCoach;
use App\Form\UserTypeAdherent;
use App\Repository\FicheSanteRepository;
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
        // Récupère l'utilisateur actuellement connecté
        $user = $this->getUser();

        // Vérifie le rôle de l'utilisateur et redirige en conséquence
        if ($user !== null && $user->getRole() == "adherent") {
            return $this->redirectToRoute('app_adherent');
        } elseif ($user !== null && $user->getRole() == "coach") {
            return $this->redirectToRoute('app_coach');
        }

        // Récupère tous les utilisateurs depuis le repository
        $users = $userRepository->findAll();

        // Rend la vue 'user/index.html.twig' avec les utilisateurs passés en paramètre
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/listusers", name="app_list_users")
     */
    public function listeUtilisateurs(UserRepository $userRepository): Response
    {
        // Récupère tous les utilisateurs depuis le repository
        $users = $userRepository->findAll();

        // Rend la vue 'adherent/list.html.twig' avec les utilisateurs passés en paramètre
        return $this->render('adherent/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/listusers2", name="app_list_users2")
     */
    public function listeUtilisateurs2(UserRepository $userRepository): Response
    {
        // Récupère tous les utilisateurs depuis le repository
        $users = $userRepository->findAll();

        // Rend la vue 'coach/list.html.twig' avec les utilisateurs passés en paramètre
        return $this->render('coach/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/adherent", name="app_adherent")
     */
    public function adherent(UserRepository $userRepository, FicheSanteRepository $ficheSanteRepository): Response
    {
        // Récupère les utilisateurs ayant le rôle "adherent" depuis le repository
        $users = $userRepository->findBy(['role' => 'adherent']);

        // Rend la vue 'adherent/index.html.twig' avec les utilisateurs et les fiches de santé passés en paramètre
        return $this->render('adherent/index.html.twig', [
            'users' => $users,
            'ficheS' => $ficheSanteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/coach", name="app_coach")
     */
    public function coach(): Response
    {
        // Récupère le repository des utilisateurs
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        // Récupère les utilisateurs ayant le rôle "adherent" depuis le repository
        $users = $userRepository->findBy(['role' => 'adherent']);

        // Rend la vue 'coach/index.html.twig' avec les utilisateurs passés en paramètre
        return $this->render('coach/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/users/new", name="app_users_new")
     */
    public function new(Request $request): Response
    {
        // Crée une nouvelle instance de l'entité User
        $user = new User();

        // Vérifie le type de formulaire à créer en fonction de la valeur du paramètre 'type' de la requête
        if ($request->get('type') == 'adherent') {
            $form = $this->createForm(UserTypeAdherent::class, $user);
        } elseif ($request->get('type') == 'coach') {
            $form = $this->createForm(UserTypeCoach::class, $user);
        } else {
            return $this->redirectToRoute('app_users_index');
        }

        // Gère la requête et le formulaire soumis
        $form->handleRequest($request);

        // Vérifie si le formulaire est valide et persiste l'utilisateur en base de données
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_users_index');
        }

        // Rend le formulaire à afficher dans la vue 'user/new.html.twig'
        return $this->renderForm('user/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/users/{id}", name="app_user_show")
     */
    public function show(User $user): Response
    {
        // Vérifie le rôle de l'utilisateur pour choisir la vue appropriée
        if ($user->getRole() == "coach") {
            return $this->render('user/show.html.twig', [
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
        // Vérifie le rôle de l'utilisateur pour choisir le type de formulaire approprié
        if ($user->getRole() == "adherent") {
            $form = $this->createForm(UserTypeAdherent::class, $user);
        } elseif ($user->getRole() == "coach") {
            $form = $this->createForm(UserTypeCoach::class, $user);
        } else {
            return $this->redirectToRoute('app_users_index');
        }

        // Gère la requête et le formulaire soumis
        $form->handleRequest($request);

        // Vérifie si le formulaire est valide et met à jour l'utilisateur en base de données
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_users_index');
        }

        // Vérifie le rôle de l'utilisateur pour choisir la vue appropriée
        if ($user->getRole() == "coach") {
            return $this->render('user/edit.html.twig', [
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
        // Vérifie si le jeton CSRF est valide avant de supprimer l'utilisateur
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users_index');
    }
}
