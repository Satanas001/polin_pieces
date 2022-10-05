<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('catégorie')
            ->setEntityLabelInPlural('Catégories')
            ->setPageTitle('new', 'Ajouter une %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier la %entity_label_singular%')
            ->setPageTitle('detail', 'Catégorie : %entity_as_string%')
            ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id') ;
        $designation = TextField::new('designation', 'Désignation') ;
        $formattedActive = BooleanField::new('active', 'Actif')
            ->setTemplatePath('admin/fields/active_field.html.twig') ;
        $active = BooleanField::new('active', 'Actif') ;

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $designation, $formattedActive] ;
        }
        elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $formattedActive] ;
        }
        else {
            return [$designation, $active] ;
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::SAVE_AND_CONTINUE)
            ->disable(Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setIcon('fa-solid fa-plus me-1')
                    ->setLabel('Ajouter') ;
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
                    ->displayIf(static function ($entity) {
                        return !count($entity->getDeviceTypes()) ;
                    }) ;
            }) 
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action
                    ->displayIf(static function ($entity) {
                        return !count($entity->getDeviceTypes()) ;
                    }) ;
            }) 
            ;
    }
}
