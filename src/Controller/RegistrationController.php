<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Entity\Coach;
use App\Entity\User;
use App\Form\UserType;
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
     * @Route("/registration", name="registration")
     */
    public function index(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Set their role
            if ($user->getRole() == 'adherent') {

                $adherent = new Adherent();

                $adherent->setEmail($user->getEmail());
                $adherent->setNom($user->getNom());
                $adherent->setPrenom($user->getPrenom());
                $adherent->setRole($user->getRole());

                $adherent->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

                $adherent->setRoles(['ROLE_ADHERENTS']);



                $em = $this->getDoctrine()->getManager();
                $em->persist($adherent);
                $em->flush();

                return $this->redirectToRoute('app_adherent_index');
            }

            if ($user->getRole() == 'coach') {

                $coach = new Coach();

                $coach->setEmail($user->getEmail());
                $coach->setNom($user->getNom());
                $coach->setPrenom($user->getPrenom());

                $coach->setRole($user->getRole());

                $coach->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

                $coach->setRoles(['ROLE_COACHS']);

                $em = $this->getDoctrine()->getManager();
                $em->persist($coach);
                $em->flush();

                return $this->redirectToRoute('app_coach_index');
            }
        }
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}