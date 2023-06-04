<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserTypeCoach;
use App\Form\UserTypeAdherent;
use App\Repository\FicheSanteRepository;
use App\Repository\InscriptionRepository;
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
    // Renvoie la liste des utilisateurs basée sur leur rôle
    public function index(UserRepository $userRepository): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();

        // Redirige en fonction du rôle de l'utilisateur
        if ($user !== null && $user->getRole() == "adherent") {
            return $this->redirectToRoute('app_adherent');
        } elseif ($user !== null && $user->getRole() == "coach") {
            return $this->redirectToRoute('app_coach');
        }

        // Récupère tous les utilisateurs
        $users = $userRepository->findAll();

        // Renvoie la vue avec tous les utilisateurs
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/listusers", name="app_list_users")
     */
    // Renvoie une liste d'utilisateurs basée sur une recherche
    public function listeUtilisateurs(Request $request, UserRepository $userRepository): Response
    {
        // Récupère la requête de recherche
        $search = $request->query->get('search');

        // Si une recherche est effectuée
        if ($search) {
            $users = $userRepository->searchAdherents($search);
        } else {
            $users = $userRepository->findAll();
        }

        // Renvoie la vue avec les utilisateurs correspondant à la recherche
        return $this->render('adherent/list.html.twig', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    /**
     * @Route("/listusers2", name="app_list_users2")
     */
    // Renvoie une liste de coachs basée sur une recherche
    public function listeCoachs(Request $request, UserRepository $userRepository): Response
    {
        // Récupère la requête de recherche
        $search = $request->query->get('search');

        // Si une recherche est effectuée
        if ($search) {
            $users = $userRepository->searchCoachs($search);
        } else {
            $users = $userRepository->findAll();
        }

        // Renvoie la vue avec les utilisateurs correspondant à la recherche
        return $this->render('coach/list.html.twig', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    /**
     * @Route("/adherent", name="app_adherent")
     */
    public function adherent(UserRepository $userRepository, FicheSanteRepository $ficheSanteRepository): Response
    {
        // Récupère les utilisateurs ayant le rôle "adherent" depuis le repository
        $users = $userRepository->findBy(['role' => 'adherent']);

        // Récupère la fiche de santé la plus récente
        $latestFicheSante = $ficheSanteRepository->findLatest();

        // Rend la vue 'adherent/index.html.twig' avec les utilisateurs et la dernière fiche de santé
        return $this->render('adherent/index.html.twig', [
            'users' => $users,
            'ficheS' => $latestFicheSante,
        ]);
    }


    /**
     * @Route("/coach", name="app_coach")
     */
    // Affiche la liste des utilisateurs ayant le rôle 'coach'
    public function coach(InscriptionRepository $inscriptionRepository): Response
    {
        // Récupère le repository des utilisateurs
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        // Récupère les utilisateurs avec le rôle 'adherent'
        $users = $userRepository->findBy(['role' => 'adherent']);

        // Renvoie la vue avec les utilisateurs
        return $this->render('coach/index.html.twig', [
            'users' => $users,
            'inscription'=>$inscriptionRepository,
        ]);
    }

    /**
     * @Route("/users/new", name="app_users_new")
     */
    // Crée un nouvel utilisateur en fonction du type spécifié
    public function new(Request $request): Response
    {
        // Crée une nouvelle instance de User
        $user = new User();

        // Crée le formulaire en fonction du type d'utilisateur
        if ($request->get('type') == 'adherent') {
            $form = $this->createForm(UserTypeAdherent::class, $user);
        } elseif ($request->get('type') == 'coach') {
            $form = $this->createForm(UserTypeCoach::class, $user);
        } else {
            return $this->redirectToRoute('app_users_index');
        }

        // Gère la requête et le formulaire soumis
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, sauvegarde l'utilisateur
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_users_index');
        }

        // Renvoie la vue avec le formulaire
        return $this->renderForm('user/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/users/{id}", name="app_user_show")
     */
    // Affiche les détails d'un utilisateur
    public function show(User $user): Response
    {
        // Renvoie la vue avec les détails de l'utilisateur
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/users/{id}/edit", name="app_user_edit")
     */
    // Modifie un utilisateur existant
    public function edit(Request $request, User $user): Response
    {
        // Crée le formulaire en fonction du rôle de l'utilisateur
        if ($user->getRole() == "adherent") {
            $form = $this->createForm(UserTypeAdherent::class, $user);
        } elseif ($user->getRole() == "coach") {
            $form = $this->createForm(UserTypeCoach::class, $user);
        } else {
            return $this->redirectToRoute('app_users_index');
        }

        // Gère la requête et le formulaire soumis
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, met à jour l'utilisateur
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_users_index');
        }

        // Renvoie la vue avec le formulaire
        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/users/{id}/delete", name="user_delete")
     */
    // Supprime un utilisateur
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
