<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\ImageFigure;
use App\Entity\Utilisateurs;
use App\Form\AvatarType;
use App\Form\FigureType;
use App\Form\ImageFigureType;
use App\Manager\UtilisateurManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class HomeController extends AbstractController
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * @Route("/{page}", name="home" ,requirements={"page":"\d+"},defaults={"page":1})
     */
    public function index($page = 1): Response
    {

        $donneRepo = $this->getDoctrine()->getRepository(ImageFigure::class)->findAll();
        $figure = $this->getDoctrine()->getRepository(Figure::class)->paginationFigure($page);
        $userRepo = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();

        return $this->render('home/index.html.twig', [
            'donnee' => $donneRepo,
            'page' => $page,
            'figure' => $figure,
            'utilisateur' => $userRepo,
        ]);
    }


    /**
     * @Route("/avatar", name="home_avatar")
     */
    public function avatar(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var Utilisateurs $avatar */
        $avatar = $this->getUser();
        $formAvatar = $this->createForm(AvatarType::class, $avatar);
        $formAvatar->handleRequest($request);

        if ($formAvatar->isSubmitted() && $formAvatar->isValid()) {
            // traitement champs document upload
            $file = $formAvatar->get('picture')->getData();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory_avatar'), $filename);
            $avatar->setPicture($filename);

            $em = $this->getDoctrine()->getManager();
            $em->persist($avatar);
            $em->flush();
            $this->addFlash('success', 'Votre avatar téléchargé avec succès ');
            return $this->redirectToRoute('home');
        }
        return $this->render('home/avatar.html.twig', [
            'avatar' => $formAvatar->createView(),
        ]);
    }


    /**
     * @Route("/formulaire",name="formulaire_")
     */
    public function fomulaires(Request $request): Response
    {
        $figure = new Figure();
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $figure->setUtilisateurs($this->getUser());
            $figure->setSlug(strtolower($this->slugger->slug($figure->getNom())));

            $entityManager = $this->getDoctrine()->getManager();

            // On boucle sur les images
            foreach ($figure->getImagefig() as $image){
                 $file = $image->getImageFile();

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
            //VIDEO
            foreach ($figure->getVideofig()as $videoFigure){

                $video =$videoFigure->getVideo();
                $videoFigure->setVideo($video);
                $videoFigure->setFigure($figure);
                $entityManager->persist($videoFigure);
            }
            $entityManager->persist($figure);
            $entityManager->flush();

            $this->addFlash('success', 'Figure ajoutée avec succès');
            return $this->redirectToRoute('home');
        }
        return $this->render('home/image_form.html.twig', [
            'form' => $form->createView(),
            'figures' => $figure,
        ]);
    }

}
