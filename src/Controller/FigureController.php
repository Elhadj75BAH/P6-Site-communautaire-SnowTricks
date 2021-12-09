<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Entity\Figure;
use App\Form\CommentairesType;
use App\Form\FigureType;
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

    // Affichage page slug //

    /**
     * @Route ("/{slug}/{page}",name="figure_details", requirements={"page":"\d+"},defaults={"page":1})
     */
    public function figure_details($slug, FigureRepository $figureRepository, Request $request,  $page=1 )
    {

        $detailsfigure = $figureRepository->findOneBy(['slug' => $slug,]);
        $commentaireFigure = $this->getDoctrine()->getRepository(Commentaires::class)->paginationCommentaire($page,$detailsfigure);

        if (!$detailsfigure) {
            throw new NotFoundHttpException('Cette figure n\'est pas disponible');
        }


        $nbreCommentaire = ceil($this->getDoctrine()->getRepository(Commentaires::class)->nbreCommentaire($detailsfigure) / 10);

        //COMMENTAIRES
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
            'commentaireFigure'=>$commentaireFigure,
            'form' => $form->createView(),
            'nbreCommentaire'=>$nbreCommentaire,
        ]);
    }


    /**
     * @Route("/{slug}/edit", name="figure_edit", methods={"GET","POST"})
     */
    public function edit($slug, Request $request, Figure $figure): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ligne ci-dessous permet de modifier le slug de la figure
            $figure->setSlug(strtolower($this->slugger->slug($figure->getNom())));
            $entityManager = $this->getDoctrine()->getManager();

            // On boucle sur les images
            foreach ($figure->getImagefig() as $image){
                 $file = $image->getImageFile(); // IMPORTANT
                if ($file) {
                    // On génère un nouveau nom de fichier
                    $filename = md5(uniqid()) . '.' . $file->guessExtension();

                    // On copie le fichier dans le dossier images
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $filename
                    );
                    // On crée l'image dans la base de données
                    $image->setImage($filename);
                    $image->setFigureimage($figure);
                    $entityManager->persist($image);
                }
            }
            //VIDEO
            foreach ($figure->getVideofig()as $videoFigure){

                $video =$videoFigure->getVideo();
                $videoFigure->setVideo($video);
                $entityManager->persist($videoFigure);
            }
            $entityManager->persist($figure);
            $entityManager->flush();

            $this->addFlash('success', 'Figure mis à jour avec succès ');

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('home/image_form.html.twig', [
            'figures' => $figure,
            'form' => $form,
            'slug' => $slug
        ]);
    }


    /**
     * @Route("/{id}/supprimer", name="figure_delete", methods={"POST"})
     */
    public function delete(Figure $figure, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($this->isCsrfTokenValid('delete' . $figure->getId(), $request->request->get('_token'))) {

            // SCRIPT POUR SUPPRIMER LES IMAGES DANS LE DOSSIER IMAGES
            $images = $figure->getImagefig();
            if($images){
                // on parcourt les images avec une boucle
                foreach ($images as $image){
                    $imageName = $this->getParameter("upload_directory") . '/'.$image->getImage();

                    // on vérifie si l'image existe
                    if(file_exists($imageName)){
                        unlink($imageName);
                      }
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($figure);
            $entityManager->flush();

            $this->addFlash('success', 'Figure supprimée avec succès  ');
        } else {
            $this->addFlash('danger', 'Erreur lors de la suppression');
        }
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

}
