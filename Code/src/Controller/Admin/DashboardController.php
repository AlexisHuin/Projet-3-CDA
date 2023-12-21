<?php

namespace App\Controller\Admin;

use App\Entity\CommentairesLieu;
use App\Entity\Contact;
use App\Entity\Itineraire;

use App\Entity\User;
use App\Entity\Cadeau;


use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'admin.index')]
    public function index(): Response
    {

        return $this->render('pages/admin/Admin.html.twig');

    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LoireValley - Admin')
            ->renderContentMaximized()
            ->setlocales([

                'fr'=>'Francais',
                'en'=>'English'

            ]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-bowl-rice', User::class);
        yield MenuItem::linkToCrud('Itineraire', 'fas fa-route', Itineraire::class);
        yield MenuItem::linkToCrud('Gift', 'fas fa-gift', Cadeau::class);
        yield MenuItem::linkToCrud('Commentaires Lieu', 'fas fa-comment', CommentairesLieu::class);
        yield MenuItem::linkToCrud('Contact', 'fas fa-comment', Contact::class);

    }
    
        
        
    

}
