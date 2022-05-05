<?php

namespace App\UseCase;

use App\Entity\Token;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;

class SecurityUseCase
{
    private EntityManagerInterface $em;
    private UtilisateurRepository $utilisateurRepository;

    public function __construct(
        EntityManagerInterface $em,
        UtilisateurRepository $utilisateurRepository
    ) {
        $this->em = $em;
        $this->utilisateurRepository = $utilisateurRepository;
    }
    
    public function verifyEmail(Token $token): void
    {
        $utilisateur = $this->utilisateurRepository->findOneBy(['tokenEmailVerification' => $token]);
        $utilisateur->setEstVerifie(true);
        $utilisateur->setTokenEmailVerification(null);
        $this->em->remove($token);
        $this->em->flush();
    }
}
