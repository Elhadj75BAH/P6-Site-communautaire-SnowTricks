<?php

namespace App\Services;

use App\Repository\UtilisateursRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer
{
    public function __construct(MailerInterface $mailer, ParameterBagInterface $parameterBag, UtilisateursRepository $utilisateursRepository)
    {

        $this->mailer = $mailer;
        $this->param = $parameterBag;
        $this->utilisateursRepository = $utilisateursRepository;
    }

    public function sendEmail($email, $token)
    {
        $email = (new TemplatedEmail())
        ->from($this->param->get('mailer_from'))
        ->to(new Address($email))
        ->subject('Création compte sur le site Snowboard ')
        ->htmlTemplate('registration/confirmation_email.html.twig')
        ->context([
            'token' => $token
        ]);

        $this->mailer->send($email);
    }

    public function sendEmailpasswoordForget($email, $token)
    {
        $email = (new TemplatedEmail())
            ->from($this->param->get('mailer_from'))
            ->to(new Address($email))
            ->subject('Rénitialisation de votre mot de passe  ')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'token' => $token
            ]);
            $this->mailer->send($email);
       // $this->mailer->send($email);
    }
}
