<?php

namespace App\Controller;

use App\Repository\CommentairesItineraireRepository;
use App\Repository\CommentairesLieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/@me')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user.index')]
    public function index(CommentairesLieuRepository $commLRepo, CommentairesItineraireRepository $commIRepo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $commCount = $commLRepo->count(['membre' => $this->getUser()]) + $commIRepo->count(['membre' => $this->getUser()]);

        return $this->render('pages/user/index.html.twig', [
            'comm_count' => $commCount
        ]);
    }

    #[Route('/favorite_places', name: 'user.favorite_places')]
    public function favoritePlaces(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('pages/user/favorite_places.html.twig');
    }

    #[Route('/settings', name: 'user.settings')]
    public function settings(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('pages/user/settings.html.twig');
    }

    #[Route('/my_gifts', name: 'user.gifts')]
    public function myGifts(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('pages/user/my_gifts.html.twig');
    }

}
