<?php
// Balise d'ouverture du code PHP

namespace App\Controller;
// Déclaration de l'espace de noms pour le contrôleur

use App\Entity\FicheSante;
use App\Entity\User;
use App\Form\FicheSanteType;
use App\Repository\FicheSanteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
// Importation des classes nécessaires à partir d'autres fichiers ou modules

/**
 * @Route("/fiche/sante")
 */
// Annotation pour définir le chemin de base pour tous les chemins dans ce contrôleur

class FicheSanteController extends AbstractController
// Définition d'une nouvelle classe nommée `FicheSanteController` qui hérite de `AbstractController`

{
    /**
     * @Route("/", name="app_fiche_sante_index", methods={"GET"})
     */
    // Annotation pour définir la route pour la méthode `index()`

    public function index(FicheSanteRepository $ficheSanteRepository): Response
        // Définition d'une fonction publique appelée `index()`

    {
        $user = $this->getUser(); // Obtenez l'utilisateur actuel ou utilisez une autre méthode pour récupérer l'utilisateur souhaité
        $userId = $user->getId();

        return $this->render('fiche_sante/index.html.twig', [
            'fiche_santes' =>  $ficheSanteRepository->findBy(['user'=>$userId]),

        ]);
        // Renvoie une réponse HTTP en rendant une vue et en y passant une liste de tous les fiches de santé
    }

    /**
     * @Route("/new", name="app_fiche_sante_new", methods={"GET", "POST"})
     */
    // Annotation pour définir la route pour la méthode `new()`

    public function new(Request $request, FicheSanteRepository $ficheSanteRepository,UserInterface $user): Response
        // Définition d'une fonction publique appelée `new()`

    {
        $ficheSante = new FicheSante();
        // Crée une nouvelle instance de l'entité FicheSante

        $form = $this->createForm(FicheSanteType::class, $ficheSante);
        // Crée un nouveau formulaire de type FicheSanteType avec l'instance de FicheSante

        $form->handleRequest($request);
        // Récupère les données du formulaire à partir de la requête HTTP et les applique à l'instance de FicheSante

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le formulaire a été soumis et si les données sont valides

            $ficheSante->setUser($user);
            // Associe la FicheSante à l'utilisateur actuel

            $ficheSanteRepository->add($ficheSante, true);
            // Ajoute la nouvelle fiche de santé à la base de données

            return $this->redirectToRoute('app_fiche_sante_index', [], Response::HTTP_SEE_OTHER);
            // Redirige l'utilisateur vers l'index des fiches de santé
        }

        return $this->renderForm('fiche_sante/new.html.twig', [
            'fiche_sante' => $ficheSante,
            'form' => $form,
        ]);
        // Rend le formulaire pour créer une nouvelle fiche de santé
    }

    /**
     * @Route("/{id}", name="app_fiche_sante_show", methods={"GET"})
     *
     */
    // Annotation pour définir la route pour la méthode `show()`

    public function show(User $user): Response
        // Définition d'une fonction publique appelée `show()`

    {
        return $this->render('fiche_sante/show.html.twig', [
            'fiche_sante' => $user->getFichesan(),
        ]);
        // Rend une vue avec les détails de la fiche de santé de l'utilisateur spécifié
    }

    /**
     * @Route("/{id}/edit", name="app_fiche_sante_edit", methods={"GET", "POST"})
     */
    // Annotation pour définir la route pour la méthode `edit()`

    public function edit(Request $request, FicheSante $ficheSante, FicheSanteRepository $ficheSanteRepository): Response
        // Définition d'une fonction publique appelée `edit()`

    {
        $form = $this->createForm(FicheSanteType::class, $ficheSante);
        // Crée un formulaire pour éditer la fiche de santé spécifiée

        $form->handleRequest($request);
        // Récupère les données du formulaire à partir de la requête HTTP et les applique à l'instance de FicheSante

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le formulaire a été soumis et si les données sont valides

            $ficheSanteRepository->add($ficheSante, true);
            // Met à jour la fiche de santé dans la base de données

            return $this->redirectToRoute('app_fiche_sante_index', [], Response::HTTP_SEE_OTHER);
            // Redirige l'utilisateur vers l'index des fiches de santé
        }

        return $this->renderForm('fiche_sante/edit.html.twig', [
            'fiche_sante' => $ficheSante,
            'form' => $form,
        ]);
        // Rend le formulaire pour éditer la fiche de santé
    }

    /**
     * @Route("/{id}", name="app_fiche_sante_delete", methods={"POST"})
     */
    // Annotation pour définir la route pour la méthode `delete()`

    public function delete(Request $request, FicheSante $ficheSante, FicheSanteRepository $ficheSanteRepository): Response
        // Définition d'une fonction publique appelée `delete()`

    {
        if ($this->isCsrfTokenValid('delete'.$ficheSante->getId(), $request->request->get('_token'))) {
            // Vérifie si le token CSRF est valide pour la suppression de la fiche de santé

            $ficheSanteRepository->remove($ficheSante, true);
            // Supprime la fiche de santé de la base de données
        }

        return $this->redirectToRoute('app_fiche_sante_index', [], Response::HTTP_SEE_OTHER);
        // Redirige l'utilisateur vers l'index des fiches de santé après la suppression
    }
}
// Fin de la classe FicheSanteController
