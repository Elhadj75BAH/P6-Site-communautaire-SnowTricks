<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\RegistrationFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Repository\UtilisateursRepository;
use App\Services\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegistrationController extends AbstractController
{

    public function __construct(Mailer $mailer, ParameterBagInterface $parameterBag, UtilisateursRepository $utilisateursRepository)
    {
        $this->mailer = $mailer;
        $this->param = $parameterBag;
        $this->utilisateursRepository = $utilisateursRepository;
    }

    /**
     * @Route("/register", name="app_register")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Utilisateurs();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setToken($this->generateToken()); //On génère le token
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->mailer->sendEmail($user->getEmail(), $user->getToken());
            $this->addFlash('success', ' Votre compte a été créé avec succès !  un email vient de vous être envoyé, cliquez sur le lien pour l\'activer  ');

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

//Confirmer l'adresse email

    /**
     * @Route("/confirmer-mon-compte/{token}", name="confirm_account")
     * @param string $token
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function confirmAccount(string $token)
    {
        $user = $this->utilisateursRepository->findOneBy(["token" => $token]);
        if ($user) {
            $user->setToken(null);
            $user->setIsVerified(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash("success", "Votre Compte a été activé avec succès !");
            return $this->redirectToRoute("home");
        } else {
            $this->addFlash("error", "OUPS UNE ERREUR S'EST PRODUITE, NOUS VOUS PRIONS DE NOUS EXCUSER.  !");
            return $this->redirectToRoute('home');
        }
    }


    /**
     * @return string
     * @throws \Exception
     */
    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }


    /**
     * @Route("/resetPassword", name="reset_pass", methods={"GET|POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function resetPassword(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ResetPasswordRequestFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // On cherche l'adresse email associée à l'utilisateur
            $user = $this->utilisateursRepository->findOneBy(['email' => $form->get('email')->getData()]);
            // On vérifie si l'utilisateur n'est pas connu on affiche ce message
            if ($user === null) {
                $this->addFlash('danger', 'Votre adresse email semble incorrect veuillez réessayez ');
                return $this->redirectToRoute('reset_pass');
            }
            if ($user !== null) {
                // on enregistre le token ResetTokenPass pour se servir après
                $user->setResetTokenPass($this->generateToken());
                $em->persist($user);
                $em->flush();
                // On envoie le mail de réinitialisation
                $this->mailer->sendEmailpasswoordForget($user->getEmail(), $user->getResetTokenPass());
                $this->addFlash('success', ' Un email contenant un lien de reinitialisation  mot de passe vient de vous être envoyé   ');
                return $this->redirectToRoute('home');
            }
        }
        return $this->render('reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }


    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param string $token
     * @Route("/resetPassword/{token}", name="resetpassword_email", methods={"GET|POST"})
     */

    public function resetPasswordToken(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, string $token)
    {
        $user = $this->getDoctrine()->getRepository(Utilisateurs::class)->findOneBy(["resetTokenPass" => $token]);

        // Si l'utilisateur n'existe pas
        if ($user === null) {
            // On affiche un message d'erreur
            $this->addFlash('danger', ' Votre lien n\'est pas valide veillez demander un autre lien pour pouvoir reinitialiser votre mot de passe ');
            return $this->redirectToRoute('home');
        }
        // si le formulaire est envoyé en methode post
        if ($request->isMethod('POST')) {
            // on supprime le token
            $user->setResetTokenPass(null);
            // on hash le mot de passe
            $user->setPassword($userPasswordEncoder->encodePassword($user, $request->request->get('password')));
            // on stock
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // On crée le message flash
            $this->addFlash('success', ' Votre Mot de passe mis à jour avec succès ! vous pouvez vous connecter ci-dessous');
            return $this->redirectToRoute('app_login');
        } else {
            return $this->render('reset_password/reset.html.twig', ['token' => $token]);
        }

    }

}
