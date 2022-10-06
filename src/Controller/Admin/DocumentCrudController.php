<?php

namespace App\Controller\Admin;

use App\Entity\Document;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('document')
            ->setEntityLabelInPlural('Documents')
            ->setPageTitle('new', 'Ajouter un %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier le %entity_label_singular% <span class="text-info">« %entity_as_string% »</span>')
            ->setPageTitle('detail', 'Document <span class="text-info">« %entity_as_string% »</span>')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id') ;
        $formattedFilename = TextField::new('filename', 'Fichier')
            ->setTemplatePath('admin/fields/document_link.html.twig') ;
        $filename = ImageField::new('filename', 'Fichier')
            ->setBasePath(self::DOCUMENTS_BASE_PATH)
            ->setUploadDir(self::DOCUMENTS_UPLOAD_DIR)
            ->setFormTypeOptions([
                'attr' => [
                    'accept' => 'application/pdf'
                ]
            ]) ;
        $category = AssociationField::new('category', 'Catégorie') ;
        $models = AssociationField::new('deviceModels','Modèles') ;
        $formattedModels = CollectionField::new('deviceModels','Modèles')
            ->setTemplatePath('admin/fields/list.html.twig') ;
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $formattedFilename, $category, $models] ;
        }
        elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $formattedFilename, $category, $formattedModels] ;
        }
        elseif (Crud::PAGE_NEW === $pageName) {
            return [$filename, $category, $models] ;
        }
        else {
            return [$category, $models] ;
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::SAVE_AND_CONTINUE)
            ->disable(Action::SAVE_AND_ADD_ANOTHER)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setIcon('fa-solid fa-plus me-1')
                    ->setLabel('Ajouter') ;
            })
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action
                    ->setIcon('fa-regular fa-eye me-1 text-success')
                    ->setLabel('Consulter') ;
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action
                    ->setIcon('fa-regular fa-pen-to-square me-1 text-warning')
                    ->setLabel('Modifier') ;
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action
                    ->setIcon('fa-solid fa-floppy-disk me-1')
                    ->setLabel('Sauvegarder') ;
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action
                    ->setIcon('fa-solid fa-plus me-1')
                    ->setLabel('Ajouter') ;
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setIcon('fa-regular fa-trash-alt me-1 text-danger')
                    ->setLabel('Supprimer')
                    ;
            })
            ;
    }
    
}
