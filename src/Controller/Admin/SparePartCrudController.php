<?php

namespace App\Controller\Admin;

use App\Entity\SparePart;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SparePartCrudController extends AbstractCrudController
{
    public const DOCUMENTS_BASE_PATH = 'images/parts' ;
    public const DOCUMENTS_UPLOAD_DIR = 'public/images/parts' ;

    public static function getEntityFqcn(): string
    {
        return SparePart::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('pièce détachée')
            ->setEntityLabelInPlural('Pièces détachées')
            ->setPageTitle('new', 'Ajouter une %entity_label_singular%')
            ->setPageTitle('edit', fn (SparePart $part) => sprintf('Modifier la pièce <span class="text-info">« %s »</span>', $part->getReference()))
            ->setPageTitle('detail', fn (SparePart $part) => sprintf('Pièce <span class="text-info">« %s »</span>', $part->getReference()))
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id') ;
        $reference = TextField::new('reference', 'Référence') ;
        $designation = TextField::new('designation', 'Désignation') ;
        $description = TextEditorField::new('description', 'Description')
            ->setTemplatePath('admin/fields/text_editor.html.twig') ;
        $price = MoneyField::new('unitPrice','Prix unitaire')
            ->setCurrency('EUR')
            ->setStoredAsCents() ;
        $image = ImageField::new('image', 'Image')
            ->setBasePath(self::DOCUMENTS_BASE_PATH)
            ->setUploadDir(self::DOCUMENTS_UPLOAD_DIR) ;
        $formattedActive = BooleanField::new('isEnabled', 'Actif')
            ->setTemplatePath('admin/fields/active_field.html.twig') ;
        $active = BooleanField::new('isEnabled', 'Actif') ;
        $devices = AssociationField::new('device','Modèle') 
            ->setQueryBuilder(function (QueryBuilder $queryBuilder) {
                $queryBuilder->where('entity.active = true') ;
            }) ;
        $formattedDevices = CollectionField::new('device','Modèles')
            ->setTemplatePath('admin/fields/list.html.twig') ;

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $reference, $designation, $description, $price, $image, $formattedActive, $devices] ;
        }
        elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $reference, $designation, $description, $price, $image, $formattedActive, $formattedDevices] ;
        }
        elseif (Crud::PAGE_NEW === $pageName) {
            return [$reference, $designation, $description, $price, $image, $active, $devices] ;
        }
        else {
            return [$reference, $designation, $description, $price, $image, $active, $devices] ;
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::SAVE_AND_CONTINUE)
            ->disable(Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
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
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action
                    ->setIcon('fa-regular fa-eye me-1 text-success')
                    ->setLabel('Consulter') ;
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
                        return false ;
                    }) ;
            }) 
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action
                    ->displayIf(static function ($entity) {
                        return false ;
                    }) ;
            })
            ;
    }
}
