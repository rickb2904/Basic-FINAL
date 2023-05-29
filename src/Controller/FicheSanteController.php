<?php

namespace App\Controller;

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

/**
 * @Route("/fiche/sante")
 */
class FicheSanteController extends AbstractController
{
    /**
     * @Route("/", name="app_fiche_sante_index", methods={"GET"})
     */
    public function index(FicheSanteRepository $ficheSanteRepository): Response
    {
        return $this->render('fiche_sante/index.html.twig', [
            'fiche_santes' => $ficheSanteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_fiche_sante_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FicheSanteRepository $ficheSanteRepository,UserInterface $user): Response
    {
        $ficheSante = new FicheSante();
        $form = $this->createForm(FicheSanteType::class, $ficheSante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ficheSante->setUser($user);
            $ficheSanteRepository->add($ficheSante, true);


            return $this->redirectToRoute('app_fiche_sante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fiche_sante/new.html.twig', [
            'fiche_sante' => $ficheSante,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_fiche_sante_show", methods={"GET"})
     *
     */
    public function show(User $user): Response
    {

        return $this->render('fiche_sante/show.html.twig', [
            'fiche_sante' => $user->getFichesan(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_fiche_sante_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, FicheSante $ficheSante, FicheSanteRepository $ficheSanteRepository): Response
    {
        $form = $this->createForm(FicheSanteType::class, $ficheSante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ficheSanteRepository->add($ficheSante, true);

            return $this->redirectToRoute('app_fiche_sante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fiche_sante/edit.html.twig', [
            'fiche_sante' => $ficheSante,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_fiche_sante_delete", methods={"POST"})
     */
    public function delete(Request $request, FicheSante $ficheSante, FicheSanteRepository $ficheSanteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ficheSante->getId(), $request->request->get('_token'))) {
            $ficheSanteRepository->remove($ficheSante, true);
        }

        return $this->redirectToRoute('app_fiche_sante_index', [], Response::HTTP_SEE_OTHER);
    }
}
