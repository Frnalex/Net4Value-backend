<?php

namespace App\UseCase;

use App\Entity\Utilisateur;
use App\Utils\TokenUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurUseCase
{
    public function __construct(
        private MailerInterface $mailer,
        private UserPasswordHasherInterface $hasher,
        private TokenUtils $tokenUtils
    ) {
    }

    public function updatePassword(Utilisateur $utilisateur): void
    {
        $utilisateur->setMotDePasse($this->hasher->hashPassword($utilisateur, $utilisateur->getPlainMotDePasse()));
        $utilisateur->eraseCredentials();
    }

    public function updateEmail(Utilisateur $utilisateur): void
    {
        $utilisateur->setTokenEmailVerification($this->tokenUtils->generate());
    
        $email = (new TemplatedEmail())
        ->from('admin@net4Value.com')
        ->to($utilisateur->getEmail())
        ->subject('Bienvenue sur Net4Value !')
        ->htmlTemplate('emails/inscription.html.twig')
        ->context(['token' => $utilisateur->getTokenEmailVerification()]);
    
        $this->mailer->send($email);
    }
}
