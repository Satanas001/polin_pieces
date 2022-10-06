<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setPageTitle('new', 'Ajouter un %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier l\'%entity_label_singular% <span class="text-info">« %entity_as_string% »</span>')
            ->setPageTitle('detail', 'Utilisateur <span class="text-info">« %entity_as_string% »</span>')
            ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        $defaultPassword = openssl_random_pseudo_bytes(8) ;
        $defaultPassword = substr(preg_replace("/[^a-zA-Z0-9]/", "", base64_encode($defaultPassword)), 0, 8) ;

        $id = IdField::new('id') ;
        $name = TextField::new('name','Nom') ;
        $mail = EmailField::new('email','Courriel') ;
        $password = TextField::new('password','Mot de Passe')
            ->setFormTypeOption('data', $defaultPassword) ;
        $hiddenPassword = HiddenField::new('password') 
            ->setFormTypeOption('data', $defaultPassword) ;
        $phone = TelephoneField::new('phone','Téléphone') ;
        $formattedPhone = TelephoneField::new('phone','Téléphone')
            ->setTemplatePath('admin/fields/text_field.html.twig') ;
        $company = AssociationField::new('company', 'Société') ;
        $roles = ArrayField::new('roles','Role') ;
        $formattedActive = BooleanField::new('status', 'Actif')
            ->setTemplatePath('admin/fields/active_field.html.twig') ;
        $active = BooleanField::new('status', 'Actif') ;

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $mail, $formattedPhone, $company, $roles, $formattedActive] ;
        }
        elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $mail, $formattedPhone, $company, $roles, $formattedActive] ;
        }
        elseif (Crud::PAGE_NEW === $pageName) { 
            return [$name, $mail, $hiddenPassword, $phone, $company, $roles, $active] ;
        }
        else {
            return [$name, $mail, $phone, $company, $roles, $active] ;
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
                        return !$entity->isAdmin() ;
                    }) ;
                    ;
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action
                    ->displayIf(static function ($entity) {
                        return !$entity->isAdmin() ;
                    }) ;
                    ;
            })
            ;
    }
    
}
