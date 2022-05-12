<?php

namespace App\Controller;

use App\Entity\Token;
use App\UseCase\SecurityUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index()
    {
        dd("accueil");
    }
}
