<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\ImageFigure;
use App\Entity\Utilisateurs;
use App\Entity\VideoFigure;
use App\Form\AvatarType;
use App\Form\FigureType;
use App\Form\ImageFigureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(Request $request, $page = 1): Response
    {

        $donneRepo = $this->getDoctrine()->getRepository(ImageFigure::class)->findAll();
        $figure = $this->getDoctrine()->getRepository(Figure::class)->paginationFigure($page);
        $userRepo = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();
        $newFormFigure = new Figure();

       /* $formFigure = $this->createForm(FigureType::class, $newFormFigure);
        $formFigure->handleRequest($request);

        if ($formFigure->isSubmitted() && $formFigure->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }*/

        $newImage = new ImageFigure();
        $formnewImage = $this->createForm(ImageFigureType::class, $newImage);
        $formnewImage->handleRequest($request);

        if ($formnewImage->isSubmitted() && $formnewImage->isValid()) {
            // traitement champs document upload
            $file = $newImage->getImage();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $filename);
            $newImage->setImage($filename);
            //
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('home/index.html.twig', [
            'donnee' => $donneRepo,
            'page' => $page,
            'figure' => $figure,
            'utilisateur' => $userRepo,
          //  'formFigure' => $formFigure->createView(),
            'formimage' => $formnewImage->createView(),
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

        //$donneRepo = $this->getDoctrine()->getRepository(ImageFigure::class)->findAll();

        //ici formulaire figure //
        $figure = new Figure();
        $image = new ImageFigure();
        $video = new  VideoFigure();
      //  $figure->getImagefig()->add($this);

        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $figure->setUtilisateurs($this->getUser());
            $figure->setSlug(strtolower($this->slugger->slug($figure->getNom())));

            // traitement champs document upload
            //$image->setImage('image');
            $file = $image->getImage();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $filename);
            $image->setImage($filename);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($figure);

            //$entityManager->flush();

            //notification
            $this->addFlash('message', 'L\'image est enregistrée avec succès');
            return $this->redirectToRoute('home');
        }
        // ici fin formulaire figure

        return $this->render('home/image_form.html.twig', [
          //  'formimage' => $formnewImage->createView(),
            'form' => $form->createView(),
           // 'donnee' => $donneRepo
        ]);
    }

}
