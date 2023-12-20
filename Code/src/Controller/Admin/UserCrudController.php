<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;


class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud):Crud
    {
        return $crud 
                ->setEntityLabelInPlural('Utilisateur')
                ->setEntityLabelInSingular('Utilisateur')
                ->setPageTitle('index', 'Loire Valley gestion des utilisateur');
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('email'),
            ArrayField::new('roles'),
            TextField::new('password'),
            ArrayField::new('gift_points'),
            DateTimeField::new('created_at'),
            TextField::new('avatar_url'),

            
        ];
    }
    
    
}
