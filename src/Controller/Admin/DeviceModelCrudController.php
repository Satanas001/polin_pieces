<?php

namespace App\Controller\Admin;

use App\Entity\DeviceModel;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DeviceModelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DeviceModel::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('modèle')
            ->setEntityLabelInPlural('Modèles')
            ->setPageTitle('new', 'Ajouter un %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier le %entity_label_singular%')
            ->setPageTitle('detail', 'Modèle : %entity_as_string%')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id') ;
        $designation = TextField::new('designation', 'Désignation') ;
        $deviceType = AssociationField::new('deviceType', 'Type de matériel') ;
        $formattedActive = BooleanField::new('active', 'Actif')
            ->setTemplatePath('admin/fields/active_field.html.twig') ;
        $active = BooleanField::new('active', 'Actif') ;

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $designation, $deviceType, $formattedActive] ;
        }
        elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $deviceType, $formattedActive] ;
        }
        else {
            return [$designation, $deviceType, $active] ;
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
                    ->displayIf(static function ($entity) {
                        return !count($entity->getSpareParts()) ;
                    }) ;
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action
                    ->displayIf(static function ($entity) {
                        return !count($entity->getSpareParts()) ;
                    }) ;
            }) 
            ;
    }
}
