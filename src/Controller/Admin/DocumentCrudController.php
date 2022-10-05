<?php

namespace App\Controller\Admin;

use App\Entity\Document;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DocumentCrudController extends AbstractCrudController
{
    public const DOCUMENTS_BASE_PATH = 'documents' ;
    public const DOCUMENTS_UPLOAD_DIR = 'public/documents' ;

    public static function getEntityFqcn(): string
    {
        return Document::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('filename', 'Fichier')
                ->setTemplatePath('admin/fields/document_link.html.twig')
                ->onlyOnIndex(),
            ImageField::new('filename', 'Fichier')
                ->setBasePath(self::DOCUMENTS_BASE_PATH)
                ->setUploadDir(self::DOCUMENTS_UPLOAD_DIR)
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => 'application/pdf'
                    ]
                ])
                ->hideOnIndex()
                ->hideWhenUpdating(),
            AssociationField::new('category', 'Catégorie'),
            AssociationField::new('deviceModels','Modèles')
        ] ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    
}
