<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserTypeAdherent;
use App\Form\UserTypeCoach;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/registration/adherent", name="registration_adherent")
     */
    public function adherent(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserTypeAdherent::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new user's password
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_ADHERENT']);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // Redirect
            return $this->redirectToRoute('app_adherent_index');
        }

        return $this->render('adherent/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/registration/coach", name="registration_coach")
     */
    public function coach(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserTypeCoach::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new user's password
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_COACH']);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // Redirect
            return $this->redirectToRoute('app_coach_index');
        }

        return $this->render('coach/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
