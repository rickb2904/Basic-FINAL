<?php

namespace App\Controller;

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
class SeanceLibreController extends AbstractController
{
    /**
     * @Route("/", name="app_seance_libre_index", methods={"GET"})
     */
    public function index(SeanceLibreRepository $seanceLibreRepository, Request $request): Response
    {

        $search = $request->query->get('search');

        // Si une recherche est effectuée
        if ($search) {
            $seances = $seanceLibreRepository->searchSeanceLibre($search);
        } else {
            $seances = $seanceLibreRepository->findAll();
        }

        return $this->render('seance_libre/index.html.twig', [
            'seance_libres' => $seances,
            'search' => $search,

        ]);
    }

    /**
     * @Route("/new", name="app_seance_libre_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SeanceLibreRepository $seanceLibreRepository): Response
    {
        $seanceLibre = new SeanceLibre();
        $form = $this->createForm(SeanceLibreType::class, $seanceLibre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seanceLibreRepository->add($seanceLibre, true);

            return $this->redirectToRoute('app_seance_libre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('seance_libre/new.html.twig', [
            'seance_libre' => $seanceLibre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_seance_libre_show", methods={"GET"})
     */
    public function show(SeanceLibre $seanceLibre): Response
    {
        return $this->render('seance_libre/show.html.twig', [
            'seance_libre' => $seanceLibre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_seance_libre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SeanceLibre $seanceLibre, SeanceLibreRepository $seanceLibreRepository): Response
    {
        $form = $this->createForm(SeanceLibreType::class, $seanceLibre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seanceLibreRepository->add($seanceLibre, true);

            return $this->redirectToRoute('app_seance_libre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('seance_libre/edit.html.twig', [
            'seance_libre' => $seanceLibre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_seance_libre_delete", methods={"POST"})
     */
    public function delete(Request $request, SeanceLibre $seanceLibre, SeanceLibreRepository $seanceLibreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seanceLibre->getId(), $request->request->get('_token'))) {
            $seanceLibreRepository->remove($seanceLibre, true);
        }

        return $this->redirectToRoute('app_seance_libre_index', [], Response::HTTP_SEE_OTHER);
    }
}
