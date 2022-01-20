<?php

namespace App\DataFixtures;

use App\Entity\Figure;
use App\Entity\GroupeFigure;
use App\Entity\ImageFigure;
use App\Entity\Utilisateurs;
use App\Entity\VideoFigure;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFigureFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        for ($u = 4; $u < 5; $u++) {
            $utilisateur = new Utilisateurs();
            $utilisateur->setNom("John$u")
                ->setEmail("$utilisateur$u@test.com")
                ->setIsVerified(1)
                ->setPicture('8cd9517240750b4efd9c150b4bd4d349.png');
            $password = $this->encoder->encodePassword($utilisateur, 'passJohndoe');
            $utilisateur->setPassword($password);
            $manager->persist($utilisateur);
        }

        //Groupe
        for ($g = 6; $g < 7; $g++) {
            $groupeFigure = new GroupeFigure();
            $groupeFigure->setNomGroupe("groupe$g");
            $manager->persist($groupeFigure)
            ;
        }

        // Figure

        $figure = new Figure();
            $figure->setNom("Les grabs")
                ->setSlug("les-grabs")
                ->setDescription("saisie de la carre frontside de la planche entre les deux pieds avec la main avant;")
                ->setUtilisateurs($utilisateur)
                ->setGroupe($groupeFigure);

            $manager->persist($figure);


        //image
        $imageFigure = new ImageFigure();
        $imageFigure->setImage("5e33f749e21bd5312f0ffb9dde61466b.png")
            ->setFigureimage($figure);
        $manager->persist($imageFigure)
        ;
        //}


        //video
        $videoFigure = new VideoFigure();
        $videoFigure->setVideo("https://www.youtube.com/embed/0uGETVnkujA")
            ->setFigure($figure);
        $manager->persist($videoFigure);

        $manager->flush();
    }
}