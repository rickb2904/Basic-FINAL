<?php

namespace App\Controller;

// Importations nécessaires pour le contrôleur
use App\Entity\SeanceLibre;
use App\Form\SeanceLibreType;
use App\Repository\SeanceLibreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/seance/libre")
 */
// Annotation pour définir la route de base pour toutes les méthodes de ce contrôleur
class SeanceLibreController extends AbstractController
// Définition d'une nouvelle classe `SeanceLibreController` qui étend `AbstractController`, qui est la classe de base pour tous les contrôleurs Symfony
{
    /**
     * @Route("/", name="app_seance_libre_index", methods={"GET"})
     */
    // Annotation pour définir la route pour la méthode `index()`. C'est la route de la page d'index des séances libres
    public function index(SeanceLibreRepository $seanceLibreRepository, Request $request): Response
        // Définition d'une fonction publique appelée `index()`. Cette méthode reçoit le dépôt de l'entité `SeanceLibre` et la requête HTTP actuelle comme arguments
    {
        $search = $request->query->get('search');
        // Récupère la requête de recherche depuis l'URL

        // Si une recherche est effectuée
        if ($search) {
            // Si une requête de recherche existe
            $seances = $seanceLibreRepository->searchSeanceLibre($search);
            // Récupère les séances libres correspondantes à la recherche à partir du dépôt
        } else {
            $seances = $seanceLibreRepository->findAll();
            // Récupère toutes les séances libres du dépôt si aucune recherche n'est effectuée
        }

        return $this->render('seance_libre/index.html.twig', [
            'seance_libres' => $seances,
            'search' => $search,
        ]);
        // Renvoie la vue de l'index des séances libres, en passant les séances libres et la requête de recherche en tant que variables de la vue
    }

    /**
     * @Route("/new", name="app_seance_libre_new", methods={"GET", "POST"})
     */
    // Annotation pour définir la route pour la méthode `new()`. C'est la route pour créer une nouvelle séance libre
    public function new(Request $request, SeanceLibreRepository $seanceLibreRepository): Response
        // Définition d'une fonction publique appelée `new()`. Cette méthode reçoit la requête HTTP actuelle et le dépôt de l'entité `SeanceLibre` comme arguments
    {
        $seanceLibre = new SeanceLibre();
        // Crée une nouvelle instance de `SeanceLibre`

        $form = $this->createForm(SeanceLibreType::class, $seanceLibre);
        // Crée un nouveau formulaire de type `SeanceLibreType` avec l'instance de `SeanceLibre`

        $form->handleRequest($request);
        // Récupère les données du formulaire à partir de la requête HTTP et les applique à l'instance de `SeanceLibre`

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide
            $seanceLibreRepository->add($seanceLibre, true);
            // Ajoute la nouvelle séance libre au dépôt

            return $this->redirectToRoute('app_seance_libre_index', [], Response::HTTP_SEE_OTHER);
            // Redirige l'utilisateur vers l'index des séances libres
        }

        return $this->renderForm('seance_libre/new.html.twig', [
            'seance_libre' => $seanceLibre,
            'form' => $form,
        ]);
        // Renvoie la vue du formulaire de création d'une nouvelle séance libre, en passant l'instance de `SeanceLibre` et le formulaire en tant que variables de la vue
    }

    /**
     * @Route("/{id}", name="app_seance_libre_show", methods={"GET"})
     */
    // Annotation pour définir la route pour la méthode `show()`. Le paramètre `{id}` dans la route sera automatiquement mappé à l'argument `$seanceLibre` de la méthode
    public function show(SeanceLibre $seanceLibre): Response
        // Définition d'une fonction publique appelée `show()`. Cette méthode reçoit une instance de `SeanceLibre` comme argument
    {
        return $this->render('seance_libre/show.html.twig', [
            'seance_libre' => $seanceLibre,
        ]);
        // Renvoie la vue de la séance libre, en passant l'instance de `SeanceLibre` en tant que variable de la vue
    }

    /**
     * @Route("/{id}/edit", name="app_seance_libre_edit", methods={"GET", "POST"})
     */
    // Annotation pour définir la route pour la méthode `edit()`. Le paramètre `{id}` dans la route sera automatiquement mappé à l'argument `$seanceLibre` de la méthode
    public function edit(Request $request, SeanceLibre $seanceLibre, SeanceLibreRepository $seanceLibreRepository): Response
        // Définition d'une fonction publique appelée `edit()`. Cette méthode reçoit la requête HTTP actuelle, une instance de `SeanceLibre`, et le dépôt de l'entité `SeanceLibre` comme arguments
    {
        $form = $this->createForm(SeanceLibreType::class, $seanceLibre);
        // Crée un nouveau formulaire de type `SeanceLibreType` avec l'instance de `SeanceLibre`

        $form->handleRequest($request);
        // Récupère les données du formulaire à partir de la requête HTTP et les applique à l'instance de `SeanceLibre`

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide
            $seanceLibreRepository->add($seanceLibre, true);
            // Met à jour la séance libre dans le dépôt

            return $this->redirectToRoute('app_seance_libre_index', [], Response::HTTP_SEE_OTHER);
            // Redirige l'utilisateur vers l'index des séances libres
        }

        return $this->renderForm('seance_libre/edit.html.twig', [
            'seance_libre' => $seanceLibre,
            'form' => $form,
        ]);
        // Renvoie la vue du formulaire d'édition de la séance libre, en passant l'instance de `SeanceLibre` et le formulaire en tant que variables de la vue
    }

    /**
     * @Route("/{id}", name="app_seance_libre_delete", methods={"POST"})
     */
    // Annotation pour définir la route pour la méthode `delete()`. Le paramètre `{id}` dans la route sera automatiquement mappé à l'argument `$seanceLibre` de la méthode
    public function delete(Request $request, SeanceLibre $seanceLibre, SeanceLibreRepository $seanceLibreRepository): Response
        // Définition d'une fonction publique appelée `delete()`. Cette méthode reçoit la requête HTTP actuelle, une instance de `SeanceLibre`, et le dépôt de l'entité `SeanceLibre` comme arguments
    {
        if ($this->isCsrfTokenValid('delete'.$seanceLibre->getId(), $request->request->get('_token'))) {
            // Si le token CSRF est valide pour cette action de suppression
            $seanceLibreRepository->remove($seanceLibre, true);
            // Supprime la séance libre du dépôt
        }

        return $this->redirectToRoute('app_seance_libre_index', [], Response::HTTP_SEE_OTHER);
        // Redirige l'utilisateur vers l'index des séances libres
    }
}
