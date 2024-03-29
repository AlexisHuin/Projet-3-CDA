<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/acceuil.html.twig');
    }
}