<?php

namespace App\Controller\Stat;
use App\Entity\Stat;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stat::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Stat')
            ->setEntityLabelInSingular('Stats')
            ->setPageTitle('index', 'Loire Valley Gestion des visites du site');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('value'),
            // DateTimeField::new('createdAT')
        ];
    }
}
