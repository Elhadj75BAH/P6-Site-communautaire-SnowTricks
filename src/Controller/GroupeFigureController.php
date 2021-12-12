<?php

namespace App\Controller;

use App\Entity\GroupeFigure;
use App\Form\GroupeFigureType;
use App\Repository\GroupeFigureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/groupe/figure")
 */
class GroupeFigureController extends AbstractController
{
    /**
     * @Route("/", name="groupe_figure_index", methods={"GET"})
     */
    public function index(GroupeFigureRepository $groupeFigureRepository): Response
    {
        return $this->render('groupe_figure/index.html.twig', [
            'groupe_figures' => $groupeFigureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="groupe_figure_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $groupeFigure = new GroupeFigure();
        $form = $this->createForm(GroupeFigureType::class, $groupeFigure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupeFigure);
            $entityManager->flush();

            return $this->redirectToRoute('groupe_figure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('groupe_figure/new.html.twig', [
            'groupe_figure' => $groupeFigure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="groupe_figure_show", methods={"GET"})
     */
    public function show(GroupeFigure $groupeFigure): Response
    {
        return $this->render('groupe_figure/show.html.twig', [
            'groupe_figure' => $groupeFigure,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="groupe_figure_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GroupeFigure $groupeFigure): Response
    {
        $form = $this->createForm(GroupeFigureType::class, $groupeFigure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('groupe_figure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('groupe_figure/edit.html.twig', [
            'groupe_figure' => $groupeFigure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="groupe_figure_delete", methods={"POST"})
     */
    public function delete(Request $request, GroupeFigure $groupeFigure): Response
    {
        if ($this->isCsrfTokenValid('delete' . $groupeFigure->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($groupeFigure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('groupe_figure_index', [], Response::HTTP_SEE_OTHER);
    }
}
