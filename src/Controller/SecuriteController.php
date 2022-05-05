<?php

namespace App\Controller;

use App\Entity\Token;
use App\UseCase\SecurityUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecuriteController extends AbstractController
{
    #[Route('/email-verification/{code}', name: 'utilisateur_email_verification')]
    public function verifyEmail(Token $token, SecurityUseCase $useCase)
    {
        $useCase->verifyEmail($token);

        dd('compte vérifié');
        return $this->json(null);
    }
}
