<?php

namespace App\Controller\Admin;

use App\Entity\Cadeau;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;



class CadeauCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    { {
            return Cadeau::class;
        }
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Cadeaux')
            ->setEntityLabelInSingular('Cadeaux')
            ->setPageTitle('index', 'Loire Valley Gestion des Cadeaux');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom_partenaire'),
            TextField::new('nom'),
            TextField::new('site_web_partenaire'),
            ArrayField::new('description'),
            // DateTimeField::new('created_at'),
            // TextField::new('date_expiration')

        ];
    }

}
