<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Entity\Figure;
use App\Form\CommentairesType;
use App\Form\FigureType;
use App\Repository\CommentairesRepository;
use App\Repository\FigureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/figure")
 */
class FigureController extends AbstractController
{

    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }


    /**
     * @Route("/", name="figure_index", methods={"GET"})
     */
    public function index(FigureRepository $figureRepository): Response
    {
        return $this->render('figure/index.html.twig', [
            'figures' => $figureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="figure_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $figure = new Figure();
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $figure->setSlug(strtolower($this->slugger->slug($figure->getNom())));
            $figure->setUtilisateurs($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($figure);
            $entityManager->flush();
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('groupe_figure/new.html.twig', [
            'form' => $form,
        ]);
    }

    // Affichage page slug //

    /**
     * @Route ("/{slug}",name="figure_details")
     */
    public function figure_details($slug, FigureRepository $figureRepository, Request $request)
    {
        $detailsfigure = $figureRepository->findOneBy(['slug' => $slug]);
        if (!$detailsfigure) {
            throw new NotFoundHttpException('Cette figure n\'est pas disponible');
        }
        //Commentaires
        $commentaire = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setUtilisateurs($this->getUser());
            $commentaire->setFigure($detailsfigure);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            $this->addFlash('success', 'Votre commentaire est envoyé avec succès');
            return $this->redirectToRoute('figure_details', ['slug' => $slug]);
        }
        return $this->render('figure/details_figure.html.twig', [
            'slug' => $slug,
            'figures' => $detailsfigure,
           // 'commentaires' => $commentaire,
            //    'comment'=>$commentairesRepository->paginationCommentaire($page),
            'form' => $form->createView(),
        ]);
    }
    // ICI FIN AFFICHAGE FIN SLUG //

    /**
     * @Route("/{slug}/edit", name="figure_edit", methods={"GET","POST"})
     */
    public function edit($slug, Request $request, Figure $figure, FigureRepository $figureRepository): Response
    {
        $formFigure = $this->createForm(FigureType::class, $figure);
        $formFigure->handleRequest($request);

        if ($formFigure->isSubmitted() && $formFigure->isValid()) {
            // ligne ci-dessous permet de modifier le slug de la figure
            $figure->setSlug(strtolower($this->slugger->slug($figure->getNom())));
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Figure mis à jour avec succès ');

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('figure/new.html.twig', [
            'figures' => $figure,
            'form' => $formFigure,
            'slug' => $slug
        ]);
    }


    /**
     * @Route("/{id}/supprimer", name="figure_delete", methods={"POST"})
     */
    public function delete(Figure $figure, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $figure->getId(), $request->request->get('_token'))) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($figure);
            $entityManager->flush();

            $this->addFlash('success', 'Figure supprimé avec succès ');
        } else {
            $this->addFlash('danger', 'Erreur lors de la suppression');
        }
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

}
