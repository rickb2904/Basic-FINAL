<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     */
    // Annotation pour définir la route pour la méthode `login()`
    public function login(AuthenticationUtils $authenticationUtils): Response
        // Définition d'une fonction publique appelée `login()`. Cette méthode reçoit une instance de `AuthenticationUtils` comme argument
    {
        // Récupère l'erreur de connexion, s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // Récupère le dernier nom d'utilisateur entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        // Renvoie la vue de connexion, en passant le dernier nom d'utilisateur et l'éventuelle erreur en tant que variables de la vue
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    // Annotation pour définir la route pour la méthode `logout()`
    public function logout()
        // Définition d'une fonction publique appelée `logout()`. Cette méthode ne reçoit aucun argument
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
        // Lève une exception indiquant que cette méthode peut rester vide, car elle sera interceptée par la clé de déconnexion sur le pare-feu de votre application
    }
}
