<?php
// Balise d'ouverture du code PHP

namespace App\Controller;
// Déclaration de l'espace de noms pour le contrôleur

use App\Entity\SeanceCollective;
use App\Form\SeanceCollectiveType;
use App\Repository\SeanceCollectiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// Importation des classes nécessaires à partir d'autres fichiers ou modules

/**
 * @Route("/seance/collective")
 */
// Annotation pour définir la route de base pour toutes les méthodes de ce contrôleur

class SeanceCollectiveController extends AbstractController
// Définition d'une nouvelle classe nommée `SeanceCollectiveController` qui hérite de `AbstractController`
{
    /**
     * @Route("/", name="app_seance_collective_index", methods={"GET"})
     */
    // Annotation pour définir la route pour la méthode `index()`

    public function index(SeanceCollectiveRepository $seanceCollectiveRepository, Request $request): Response
        // Définition d'une fonction publique appelée `index()`. Cette méthode reçoit le dépôt de l'entité `SeanceCollective` et la requête HTTP actuelle comme arguments
    {
        $search = $request->query->get('search');
        // Récupère le paramètre de recherche à partir de la requête HTTP

        if ($search) {
            // Si une recherche est effectuée
            $seances = $seanceCollectiveRepository->searchSeanceCollective($search);
            // Recherche les séances collectives qui correspondent aux critères de recherche
        } else {
            $seances = $seanceCollectiveRepository->findAll();
            // Sinon, récupère toutes les séances collectives
        }

        return $this->render('seance_collective/index.html.twig', [
            'seance_collectives' => $seances,
            'search' => $search,
        ]);
        // Renvoie la vue de l'index des séances collectives, en passant les séances collectives et le critère de recherche en tant que variables de la vue
    }

    /**
     * @Route("/new", name="app_seance_collective_new", methods={"GET", "POST"})
     */
    // Annotation pour définir la route pour la méthode `new()`

    public function new(Request $request, SeanceCollectiveRepository $seanceCollectiveRepository): Response
        // Définition d'une fonction publique appelée `new()`. Cette méthode reçoit la requête HTTP actuelle et le dépôt de l'entité `SeanceCollective` comme arguments
    {
        $seanceCollective = new SeanceCollective();
        // Crée une nouvelle instance de l'entité `SeanceCollective`

        $form = $this->createForm(SeanceCollectiveType::class, $seanceCollective);
        // Crée un nouveau formulaire de type `SeanceCollectiveType` avec l'instance de `SeanceCollective`

        $form->handleRequest($request);
        // Récupère les données du formulaire à partir de la requête HTTP et les applique à l'instance de `SeanceCollective`

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le formulaire a été soumis et si les données sont valides

            $seanceCollectiveRepository->add($seanceCollective, true);
            // Ajoute la nouvelle séance collective au dépôt

            return $this->redirectToRoute('app_seance_collective_index', [], Response::HTTP_SEE_OTHER);
            // Redirige l'utilisateur vers l'index des séances collectives
        }

        return $this->renderForm('seance_collective/new.html.twig', [
            'seance_collective' => $seanceCollective,
            'form' => $form,
        ]);
        // Renvoie la vue du formulaire pour créer une nouvelle séance collective, en passant l'instance de `SeanceCollective` et le formulaire en tant que variables de la vue
    }

    /**
     * @Route("/{id}", name="app_seance_collective_show", methods={"GET"})
     */
    // Annotation pour définir la route pour la méthode `show()`. Le paramètre `{id}` dans la route sera automatiquement mappé à l'argument `$seanceCollective` de la méthode

    public function show(SeanceCollective $seanceCollective): Response
        // Définition d'une fonction publique appelée `show()`. Cette méthode reçoit une instance de `SeanceCollective` comme argument
    {
        return $this->render('seance_collective/show.html.twig', [
            'seance_collective' => $seanceCollective,
        ]);
        // Renvoie la vue d'une séance collective spécifique, en passant l'instance de `SeanceCollective` en tant que variable de la vue
    }

    /**
     * @Route("/{id}/edit", name="app_seance_collective_edit", methods={"GET", "POST"})
     */
    // Annotation pour définir la route pour la méthode `edit()`. Le paramètre `{id}` dans la route sera automatiquement mappé à l'argument `$seanceCollective` de la méthode

    public function edit(Request $request, SeanceCollective $seanceCollective, SeanceCollectiveRepository $seanceCollectiveRepository): Response
        // Définition d'une fonction publique appelée `edit()`. Cette méthode reçoit la requête HTTP actuelle, une instance de `SeanceCollective`, et le dépôt de l'entité `SeanceCollective` comme arguments
    {
        $form = $this->createForm(SeanceCollectiveType::class, $seanceCollective);
        // Crée un nouveau formulaire de type `SeanceCollectiveType` avec l'instance de `SeanceCollective`

        $form->handleRequest($request);
        // Récupère les données du formulaire à partir de la requête HTTP et les applique à l'instance de `SeanceCollective`

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le formulaire a été soumis et si les données sont valides

            $seanceCollectiveRepository->add($seanceCollective, true);
            // Met à jour la séance collective dans le dépôt

            return $this->redirectToRoute('app_seance_collective_index', [], Response::HTTP_SEE_OTHER);
            // Redirige l'utilisateur vers l'index des séances collectives
        }

        return $this->renderForm('seance_collective/edit.html.twig', [
            'seance_collective' => $seanceCollective,
            'form' => $form,
        ]);
        // Renvoie la vue du formulaire pour modifier une séance collective, en passant l'instance de `SeanceCollective` et le formulaire en tant que variables de la vue
    }

    /**
     * @Route("/{id}", name="app_seance_collective_delete", methods={"POST"})
     */
    // Annotation pour définir la route pour la méthode `delete()`. Le paramètre `{id}` dans la route sera automatiquement mappé à l'argument `$seanceCollective` de la méthode

    public function delete(Request $request, SeanceCollective $seanceCollective, SeanceCollectiveRepository $seanceCollectiveRepository): Response
        // Définition d'une fonction publique appelée `delete()`. Cette méthode reçoit la requête HTTP actuelle, une instance de `SeanceCollective`, et le dépôt de l'entité `SeanceCollective` comme arguments
    {
        if ($this->isCsrfTokenValid('delete'.$seanceCollective->getId(), $request->request->get('_token'))) {
            // Vérifie si le jeton CSRF est valide

            $seanceCollectiveRepository->remove($seanceCollective, true);
            // Supprime la séance collective du dépôt
        }

        return $this->redirectToRoute('app_seance_collective_index', [], Response::HTTP_SEE_OTHER);
        // Redirige l'utilisateur vers l'index des séances collectives
    }
}
// Fin de la classe `SeanceCollectiveController`
