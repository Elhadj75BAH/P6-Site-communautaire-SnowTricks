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

class AppFixtures9 extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        for ($u = 11; $u < 12; $u++) {
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
        $figure->setNom("seat belt")
            ->setSlug("seat-belt")
            ->setDescription("saisie du carre frontside à l'arrière avec la main avant")
            ->setUtilisateurs($utilisateur)
            ->setGroupe($groupeFigure);

        $manager->persist($figure);

        //image
        $imageFigure = new ImageFigure();
        $imageFigure->setImage("9d5ee50f0fbb23108c7f5cc88eb86ae8.png")
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