<?php

namespace App\Controller;

use App\Entity\ImageFigure;
use App\Form\ImageFigureType;
use App\Repository\ImageFigureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/image/figure")
 */
class ImageFigureController extends AbstractController
{
    /**
     * @Route("/", name="image_figure_index", methods={"GET"})
     */
    public function index(ImageFigureRepository $imageFigureRepository): Response
    {
        return $this->render('image_figure/index.html.twig', [
            'image_figures' => $imageFigureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="image_figure_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $imageFigure = new ImageFigure();
        $form = $this->createForm(ImageFigureType::class, $imageFigure);
        $form->handleRequest($request);

        if ($form-> isSubmitted()&& $form->isValid()){
            // traitement champs document upload
            $file =$imageFigure->getImage();
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $imageFigure->setImage($filename);
            //
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager-> persist($imageFigure);

            $entityManager-> flush();
            //notification
            $this->addFlash('message','L\'image est enregistrée avec succès');
            return $this->redirectToRoute('home');
        }

        return $this->renderForm('image_figure/new.html.twig', [
            'image_figure' => $imageFigure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="image_figure_show", methods={"GET"})
     */
    public function show(ImageFigure $imageFigure): Response
    {
        return $this->render('image_figure/show.html.twig', [
            'image_figure' => $imageFigure,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="image_figure_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ImageFigure $imageFigure): Response
    {
        $form = $this->createForm(ImageFigureType::class, $imageFigure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('image_figure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('image_figure/edit.html.twig', [
            'image_figure' => $imageFigure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="image_figure_delete", methods={"POST"})
     */
    public function delete(Request $request, ImageFigure $imageFigure): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imageFigure->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($imageFigure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('image_figure_index', [], Response::HTTP_SEE_OTHER);
    }
}
