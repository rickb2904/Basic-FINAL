<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activite")
 */
class ActiviteController extends AbstractController
{
    /**
     * @Route("/", name="app_activite_index", methods={"GET"})
     */
    // Annotation pour définir la route pour la méthode `index()`

    public function index(ActiviteRepository $activiteRepository,  Request $request): Response
        // Définition d'une fonction publique appelée `index()`

    {
        $search = $request->query->get('search');
        // Récupération de la valeur du paramètre 'search' de la requête

        // Si une recherche est effectuée
        if ($search) {
            $activite = $activiteRepository->searchActivite($search);
            // Recherche d'activités en utilisant la méthode `searchActivite()`
        } else {
            $activite = $activiteRepository->findAll();
            // Récupération de toutes les activités si aucune recherche n'est effectuée
        }

        return $this->render('activite/index.html.twig', [
            'activites' => $activite,
            'search' => $search,
        ]);
        // Renvoie une réponse HTTP en rendant une vue et en y passant des variables
    }

    /**
     * @Route("/new", name="app_activite_new", methods={"GET", "POST"})
     */
    // Définit une route pour la création d'une nouvelle activité

    public function new(Request $request, ActiviteRepository $activiteRepository): Response
        // Définit une fonction publique appelée `new()`

    {
        $activite = new Activite();
        // Crée une nouvelle instance de l'entité Activite

        $form = $this->createForm(ActiviteType::class, $activite);
        // Crée un nouveau formulaire de type ActiviteType avec l'instance d'activité

        $form->handleRequest($request);
        // Récupère les données du formulaire à partir de la requête HTTP et les applique à l'instance d'activité

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le formulaire a été soumis et si les données sont valides

            $activiteRepository->add($activite, true);
            // Ajoute la nouvelle activité à la base de données

            return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
            // Redirige l'utilisateur vers l'index des activités
        }

        return $this->renderForm('activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
        // Rend le formulaire pour créer une nouvelle activité
    }

    /**
     * @Route("/{id}", name="app_activite_show", methods={"GET"})
     */
    // Définit une route pour afficher une activité

    public function show(Activite $activite): Response
        // Définit une fonction publique appelée `show()`

    {
        return $this->render('activite/show.html.twig', [
            'activite' => $activite,
        ]);
        // Rend la vue pour afficher une activité
    }

    /**
     * @Route("/{id}/edit", name="app_activite_edit", methods={"GET", "POST"})
     */
    // Définit une route pour éditer une activité

    public function edit(Request $request, Activite $activite, ActiviteRepository $activiteRepository): Response
        // Définit une fonction publique appelée `edit()`

    {
        $form = $this->createForm(ActiviteType::class, $activite);
        // Crée un formulaire pour éditer l'activité

        $form->handleRequest($request);
        // Récupère les données du formulaire à partir de la requête HTTP et les applique à l'instance d'activité

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le formulaire a été soumis et si les données sont valides

            $activiteRepository->add($activite, true);
            // Met à jour l'activité dans la base de données

            return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
            // Redirige l'utilisateur vers l'index des activités
        }

        return $this->renderForm('activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
        // Rend le formulaire pour éditer l'activité
    }

    /**
     * @Route("/{id}", name="app_activite_delete", methods={"POST"})
     */
    // Définit une route pour supprimer une activité

    public function delete(Request $request, Activite $activite, ActiviteRepository $activiteRepository): Response
        // Définit une fonction publique appelée `delete()`

    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {
            // Vérifie si le token CSRF est valide pour la suppression de l'activité

            $activiteRepository->remove($activite, true);
            // Supprime l'activité de la base de données
        }

        return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
        // Redirige l'utilisateur vers l'index des activités après la suppression
    }
}
// Fin de la classe ActiviteController
