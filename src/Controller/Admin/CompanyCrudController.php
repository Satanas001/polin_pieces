<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('société')
            ->setEntityLabelInPlural('Sociétés')
            ->setPageTitle('new', 'Ajouter une %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier la %entity_label_singular%')
            ->setPageTitle('detail', '<span class="text-info">%entity_as_string%</span>')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id') ;
        $companyName = TextField::new('companyName', 'Nom de la société') ;
        $siret = TextField::new('siret', 'SIRET') ;
        $address = TextField::new('address', 'Adresse') ;
        $additionalAddress = TextField::new('additionalAddress', 'Complément d\'adresse') ;
        $formattedAdditionalAddress = TextField::new('additionalAddress', 'Complément d\'adresse')
            ->setTemplatePath('admin/fields/text_field.html.twig') ;
        $postalCode = TextField::new('postalCode', 'Code postal') ;
        $city = TextField::new('city','Ville') ;
        $formattedActive = BooleanField::new('active', 'Actif')
            ->setTemplatePath('admin/fields/active_field.html.twig') ;
        $active = BooleanField::new('active', 'Actif') ;
        $users = AssociationField::new('users','Utilisateurs') ;
        $formattedUsers = CollectionField::new('users','Utilisateur')
            ->setTemplatePath('admin/fields/list.html.twig') ;

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $companyName, $siret, $address, $formattedAdditionalAddress, $postalCode, $city, $users, $formattedActive] ;
        }
        elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $siret, $address, $formattedAdditionalAddress, $postalCode, $city, $formattedActive, $formattedUsers] ;
        }
        else {
            return [$companyName, $siret, $address, $additionalAddress, $postalCode, $city, $active] ;
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
                        return !count($entity->getUsers()) ;
                    }) ;
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action
                    ->displayIf(static function ($entity) {
                        return !count($entity->getUsers()) ;
                    }) ;
            }) 
            ;
    }
}
