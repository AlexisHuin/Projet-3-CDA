<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'Bonjour')]
    public function index(): Response
    {
        return $this->render('acceuil.html.twig', [
            'random_number' => rand(0, 100)
        ]);
    }
}