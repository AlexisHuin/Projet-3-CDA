<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    { {
            return Contact::class;
        }
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Contacts')
            ->setEntityLabelInSingular('Contact')
            ->setPageTitle('index', 'Loire Valley Gestion des forms de Contacts');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            TextField::new('title'),
            TextField::new('comment'),
        ];
    }

}
