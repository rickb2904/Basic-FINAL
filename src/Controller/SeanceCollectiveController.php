<?php

namespace App\Controller;

use App\Entity\SeanceCollective;
use App\Form\SeanceCollectiveType;
use App\Repository\SeanceCollectiveRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/seance/collective")
 */
class SeanceCollectiveController extends AbstractController
{
    /**
     * @Route("/", name="app_seance_collective_index", methods={"GET"})
     */
    public function index(SeanceCollectiveRepository $seanceCollectiveRepository, Request $request): Response
    {
        $search = $request->query->get('search');

        // Si une recherche est effectuée
        if ($search) {
            $seances = $seanceCollectiveRepository->searchSeanceCollective($search);
        } else {
            $seances = $seanceCollectiveRepository->findAll();
        }

        return $this->render('seance_collective/index.html.twig', [
            'seance_collectives' => $seances,
            'search' => $search,
        ]);
    }


    /**
     * @Route("/new", name="app_seance_collective_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SeanceCollectiveRepository $seanceCollectiveRepository): Response
    {
        $seanceCollective = new SeanceCollective();
        $form = $this->createForm(SeanceCollectiveType::class, $seanceCollective);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seanceCollectiveRepository->add($seanceCollective, true);

            return $this->redirectToRoute('app_seance_collective_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('seance_collective/new.html.twig', [
            'seance_collective' => $seanceCollective,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_seance_collective_show", methods={"GET"})
     */
    public function show(SeanceCollective $seanceCollective): Response
    {
        return $this->render('seance_collective/show.html.twig', [
            'seance_collective' => $seanceCollective,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_seance_collective_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SeanceCollective $seanceCollective, SeanceCollectiveRepository $seanceCollectiveRepository): Response
    {
        $form = $this->createForm(SeanceCollectiveType::class, $seanceCollective);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seanceCollectiveRepository->add($seanceCollective, true);

            return $this->redirectToRoute('app_seance_collective_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('seance_collective/edit.html.twig', [
            'seance_collective' => $seanceCollective,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_seance_collective_delete", methods={"POST"})
     */
    public function delete(Request $request, SeanceCollective $seanceCollective, SeanceCollectiveRepository $seanceCollectiveRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seanceCollective->getId(), $request->request->get('_token'))) {
            $seanceCollectiveRepository->remove($seanceCollective, true);
        }

        return $this->redirectToRoute('app_seance_collective_index', [], Response::HTTP_SEE_OTHER);
    }
}
