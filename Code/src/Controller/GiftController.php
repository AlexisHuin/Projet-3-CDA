<?php

namespace App\Controller;

use App\Repository\CadeauRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GiftController extends AbstractController
{
    #[Route('/gift', name: 'app_gift')]
    public function index(CadeauRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $cadeaux = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('gift/gift.html.twig', [
            'cadeaux' => $cadeaux
        ]);
    }
}
