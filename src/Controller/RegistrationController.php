<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\RegistrationFormType;
use App\Repository\UtilisateursRepository;
use App\Security\EmailVerifier;
use App\Services\Mailer;
use phpDocumentor\Reflection\Types\Context;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
 /*   private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }
*/
    public function __construct(Mailer $mailer, ParameterBagInterface $parameterBag, UtilisateursRepository $utilisateursRepository)
    {
        //$this-> = $emailVerifier;
        $this->mailer=$mailer;
        $this->param =$parameterBag;
        $this->utilisateursRepository = $utilisateursRepository;
    }

    /**
     * @Route("/register", name="app_register")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder ,MailerInterface $mailer): Response
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
            //
            $user->setToken($this->generateToken());
            //
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->mailer->sendEmail($user->getEmail(),$user->getToken());

           $this->addFlash('success','Félicitation Votre compte à été crée avec succès!  un email vient de vous être envoyé   ');

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
        if($user) {
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
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request, UtilisateursRepository $utilisateursRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $utilisateursRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('home');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre adresse e-mail a été vérifiée avec succès');

        return $this->redirectToRoute('home');
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
