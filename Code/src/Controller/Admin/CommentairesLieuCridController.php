<?php

namespace App\Controller\Admin;

use App\Entity\CommentairesLieu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field as EasyAdminField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentairesLieuCridController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    { {
            return CommentairesLieu::class;
        }
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Commentaires Lieu')
            ->setEntityLabelInSingular('Commentaires Lieu')
            ->setPageTitle('index', 'Loire Valley Gestion des Commentaires Lieu');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            EasyAdminField\TextField::new('lieu_id'),
            EasyAdminField\TextField::new('titre'),
            EasyAdminField\TextEditorField::new('description'),
            EasyAdminField\IntegerField::new('note'),
            EasyAdminField\AssociationField::new('membre'),
        ];
    }

}
