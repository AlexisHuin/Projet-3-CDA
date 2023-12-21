<?php

namespace App\Controller\Admin;

use App\Entity\Itineraire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ItineraireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    { {
            return Itineraire::class;
        }
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Itineraires')
            ->setEntityLabelInSingular('Itineraires')
            ->setPageTitle('index', 'Loire Valley Gestion des Itineraires');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }

}
