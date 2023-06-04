<?php
// Balise d'ouverture du code PHP

namespace App\Controller;
// Déclaration de l'espace de noms pour le contrôleur

use App\Entity\Inscription;
use App\Entity\User;
use App\Form\InscriptionType;
use App\Repository\InscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
// Importation des classes nécessaires à partir d'autres fichiers ou modules

/**
 * @Route("/inscription")
 */
// Annotation pour définir le chemin de base pour toutes les routes dans ce contrôleur

class InscriptionController extends AbstractController
// Définition d'une nouvelle classe nommée `InscriptionController` qui hérite de `AbstractController`
{
    /**
     * @Route("/", name="app_inscription_index", methods={"GET"})
     */
    // Annotation pour définir la route pour la méthode `index()`

    public function index(InscriptionRepository $inscriptionRepository, UserInterface $user): Response
        // Définition d'une fonction publique appelée `index()`

    {
        return $this->render('inscription/index.html.twig', [
            'inscriptions' => $inscriptionRepository->findBy(['adherent'=>$user]),
        ]);
        // Renvoie une réponse HTTP en rendant une vue et en y passant une liste de toutes les inscriptions de l'utilisateur
    }

    /**
     * @Route("/new", name="app_inscription_new", methods={"GET", "POST"})
     */
    // Annotation pour définir la route pour la méthode `new()`

    public function new(Request $request, InscriptionRepository $inscriptionRepository, UserInterface $user): Response
        // Définition d'une fonction publique appelée `new()`

    {
        $inscription = new Inscription();
        // Crée une nouvelle instance de l'entité Inscription

        $form = $this->createForm(InscriptionType::class, $inscription);
        // Crée un nouveau formulaire de type InscriptionType avec l'instance de Inscription

        $form->handleRequest($request);
        // Récupère les données du formulaire à partir de la requête HTTP et les applique à l'instance de Inscription

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le formulaire a été soumis et si les données sont valides

            $inscription->setAdherent($user);
            // Associe l'Inscription à l'utilisateur actuel

            $inscriptionRepository->add($inscription, true);
            // Ajoute la nouvelle inscription à la base de données

            return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
            // Redirige l'utilisateur vers l'index des inscriptions
        }

        return $this->renderForm('inscription/new.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
        // Rend le formulaire pour créer une nouvelle inscription
    }

    /**
     * @Route("/{id}", name="app_inscription_show", methods={"GET"})
     */
    // Annotation pour définir la route pour la méthode `show()`

    public function show(Inscription $inscription): Response
        // Définition d'une fonction publique appelée `show()`

    {
        return $this->render('inscription/show.html.twig', [
            'inscription' => $inscription,
        ]);
        // Rend une vue avec les détails de l'inscription spécifiée
    }

    /**
     * @Route("/{id}/edit", name="app_inscription_edit", methods={"GET", "POST"})
     */
    // Annotation pour définir la route pour la méthode `edit()`

    public function edit(Request $request, Inscription $inscription, InscriptionRepository $inscriptionRepository): Response
        // Définition d'une fonction publique appelée `edit()`

    {
        $form = $this->createForm(InscriptionType::class, $inscription);
        // Crée un formulaire pour éditer l'inscription spécifiée

        $form->handleRequest($request);
        // Récupère les données du formulaire à partir de la requête HTTP et les applique à l'instance de Inscription

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le formulaire a été soumis et si les données sont valides

            $inscriptionRepository->add($inscription, true);
            // Met à jour l'inscription dans la base de données

            return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
            // Redirige l'utilisateur vers l'index des inscriptions
        }

        return $this->renderForm('inscription/edit.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
        // Rend le formulaire pour éditer l'inscription
    }

    /**
     * @Route("/{id}", name="app_inscription_delete", methods={"POST"})
     */
    // Annotation pour définir la route pour la méthode `delete()`

    public function delete(Request $request, Inscription $inscription, InscriptionRepository $inscriptionRepository): Response
        // Définition d'une fonction publique appelée `delete()`

    {
        if ($this->isCsrfTokenValid('delete'.$inscription->getId(), $request->request->get('_token'))) {
            // Vérifie si le token CSRF est valide pour la suppression de l'inscription

            $inscriptionRepository->remove($inscription, true);
            // Supprime l'inscription de la base de données
        }

        return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
        // Redirige l'utilisateur vers l'index des inscriptions après la suppression
    }
}
// Fin de la classe InscriptionController
