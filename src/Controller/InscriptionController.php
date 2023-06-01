<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\User;
use App\Form\InscriptionType;
use App\Repository\InscriptionRepository;
use App\Repository\SeanceCollectiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/inscription")
 */
class InscriptionController extends AbstractController
{
    /**
     * @Route("/", name="app_inscription_index", methods={"GET"})
     */
    public function index(InscriptionRepository $inscriptionRepository,UserInterface $user): Response
    {
        return $this->render('inscription/index.html.twig', [
            'inscriptions' => $inscriptionRepository->findBy(['adherent'=>$user]),
        ]);

    }

    /**
     * @Route("/new", name="app_inscription_new", methods={"GET", "POST"})
     */
    public function new(Request $request, InscriptionRepository $inscriptionRepository,UserInterface $user): Response
    {
        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inscription->setAdherent($user);
            $inscriptionRepository->add($inscription, true);

            return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscription/new.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_inscription_show", methods={"GET"})
     */
    public function show(Inscription $inscription): Response
    {
        return $this->render('inscription/show.html.twig', [
            'inscription' => $inscription,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_inscription_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Inscription $inscription, InscriptionRepository $inscriptionRepository): Response
    {
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inscriptionRepository->add($inscription, true);

            return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscription/edit.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_inscription_delete", methods={"POST"})
     */
    public function delete(Request $request, Inscription $inscription, InscriptionRepository $inscriptionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inscription->getId(), $request->request->get('_token'))) {
            $inscriptionRepository->remove($inscription, true);
        }

        return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
    }
}
