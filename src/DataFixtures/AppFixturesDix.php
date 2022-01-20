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

class AppFixturesDix extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        for ($u = 12; $u < 13; $u++) {
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
            $manager->persist($groupeFigure);
        }

        // Figure

        $figure = new Figure();
        $figure->setNom("truck driver")
            ->setSlug("truck driver")
            ->setDescription(" saisie du carre avant et carre arrière avec chaque main;")
            ->setUtilisateurs($utilisateur)
            ->setGroupe($groupeFigure);

        $manager->persist($figure);

        //image
        $imageFigure = new ImageFigure();
        $imageFigure->setImage("a0e8d392c057b84ff0b688d77bbde7bc.png")
            ->setFigureimage($figure);
        $manager->persist($imageFigure);
        //}


        //video
        $videoFigure = new VideoFigure();
        $videoFigure->setVideo("https://www.youtube.com/embed/0uGETVnkujA")
            ->setFigure($figure);
        $manager->persist($videoFigure);

        $manager->flush();
    }
}