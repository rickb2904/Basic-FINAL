<?php
// Balise d'ouverture du code PHP

namespace App\Controller;
// Déclaration de l'espace de noms pour le contrôleur

use App\Entity\User;
use App\Form\UserTypeAdherent;
use App\Form\UserTypeCoach;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
// Importation des classes nécessaires à partir d'autres fichiers ou modules

class RegistrationController extends AbstractController
// Définition d'une nouvelle classe nommée `RegistrationController` qui hérite de `AbstractController`
{
    private $passwordEncoder;
    // Définition d'une propriété privée `$passwordEncoder`

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
        // Constructeur de la classe `RegistrationController`. Il est automatiquement appelé lorsqu'une nouvelle instance de la classe est créée
    {
        $this->passwordEncoder = $passwordEncoder;
        // Affectation de l'objet `$passwordEncoder` (qui est injecté dans le constructeur) à la propriété `$passwordEncoder`
    }

    /**
     * @Route("/registration/adherent", name="registration_adherent")
     */
    // Annotation pour définir la route pour la méthode `adherent()`

    public function adherent(Request $request)
        // Définition d'une fonction publique appelée `adherent()`
    {
        $user = new User();
        // Crée une nouvelle instance de l'entité User

        $form = $this->createForm(UserTypeAdherent::class, $user);
        // Crée un nouveau formulaire de type UserTypeAdherent avec l'instance de User

        $form->handleRequest($request);
        // Récupère les données du formulaire à partir de la requête HTTP et les applique à l'instance de User

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le formulaire a été soumis et si les données sont valides

            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            // Encode le mot de passe du nouvel utilisateur

            $user->setRoles(['ROLE_ADHERENT']);
            // Définit le rôle de l'utilisateur en tant qu'adhérent

            $em = $this->getDoctrine()->getManager();
            // Récupère le gestionnaire d'entités de Doctrine

            $em->persist($user);
            // Prépare l'utilisateur à être sauvegardé dans la base de données

            $em->flush();
            // Exécute la requête pour effectivement sauvegarder l'utilisateur dans la base de données

            return $this->redirectToRoute('app_login');
            // Redirige l'utilisateur vers la page de login
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
        // Rend le formulaire pour créer un nouvel utilisateur adhérent
    }

    /**
     * @Route("/registration/coach", name="registration_coach")
     */
    // Annotation pour définir la route pour la méthode `coach()`

    public function coach(Request $request)
        // Définition d'une fonction publique appelée `coach()`
    {
        $user = new User();
        // Crée une nouvelle instance de l'entité User

        $form = $this->createForm(UserTypeCoach::class, $user);
        // Crée un nouveau formulaire de type UserTypeCoach avec l'instance de User

        $form->handleRequest($request);
        // Récupère les données du formulaire à partir de la requête HTTP et les applique à l'instance de User

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si le formulaire a été soumis et si les données sont valides

            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            // Encode le mot de passe du nouvel utilisateur

            $user->setRoles(['ROLE_COACH']);
            // Définit le rôle de l'utilisateur en tant que coach

            $em = $this->getDoctrine()->getManager();
            // Récupère le gestionnaire d'entités de Doctrine

            $em->persist($user);
            // Prépare l'utilisateur à être sauvegardé dans la base de données

            $em->flush();
            // Exécute la requête pour effectivement sauvegarder l'utilisateur dans la base de données

            return $this->redirectToRoute('app_login');
            // Redirige l'utilisateur vers la page de login
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
        // Rend le formulaire pour créer un nouvel utilisateur coach
    }
}
// Fin de la classe RegistrationController
