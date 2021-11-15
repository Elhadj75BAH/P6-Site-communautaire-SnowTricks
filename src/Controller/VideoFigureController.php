<?php

namespace App\Controller;

use App\Entity\VideoFigure;
use App\Form\VideoFigureType;
use App\Repository\VideoFigureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/video/figure")
 */
class VideoFigureController extends AbstractController
{
    /**
     * @Route("/", name="video_figure_index", methods={"GET"})
     */
    public function index(VideoFigureRepository $videoFigureRepository): Response
    {
        return $this->render('video_figure/index.html.twig', [
            'video_figures' => $videoFigureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="video_figure_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $videoFigure = new VideoFigure();
        $form = $this->createForm(VideoFigureType::class, $videoFigure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //
            $file =$videoFigure->getVideo();
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $videoFigure->setVideo($filename);

            //

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($videoFigure);
            $entityManager->flush();

            return $this->redirectToRoute('video_figure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('video_figure/new.html.twig', [
            'video_figure' => $videoFigure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="video_figure_show", methods={"GET"})
     */
    public function show(VideoFigure $videoFigure): Response
    {
        return $this->render('video_figure/show.html.twig', [
            'video_figure' => $videoFigure,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="video_figure_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VideoFigure $videoFigure): Response
    {
        $form = $this->createForm(VideoFigureType::class, $videoFigure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('video_figure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('video_figure/edit.html.twig', [
            'video_figure' => $videoFigure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="video_figure_delete", methods={"POST"})
     */
    public function delete(Request $request, VideoFigure $videoFigure): Response
    {
        if ($this->isCsrfTokenValid('delete'.$videoFigure->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($videoFigure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('video_figure_index', [], Response::HTTP_SEE_OTHER);
    }
}
