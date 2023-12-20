<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\CommentairesItineraireRepository;
use App\Repository\CommentairesLieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/settings', name: 'user.settings', methods: ['GET', 'POST'])]
    public function settings(Request $request, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(UserType::class, $this->getUser());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Vos informations ont été mises à jour.');
            return $this->redirectToRoute('user.index');
        }

        return $this->render('pages/user/settings.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/my_gifts', name: 'user.gifts')]
    public function myGifts(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('pages/user/my_gifts.html.twig');
    }

}
