<?php

namespace App\Controller\Admin;

use App\Entity\Quotation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class QuotationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quotation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('devis')
            ->setEntityLabelInPlural('Devis')
            ->setPageTitle('new', 'Ajouter un %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier le %entity_label_singular%')
            ->setPageTitle('detail', 'Devis n°<span class="text-info">%entity_id%</span>')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id','N° devis') ;
        $creationDate = DateTimeField::new('creationDate','Date de création') ;
        $status = IntegerField::new('status', 'Statut') ;
        $validationDate = DateTimeField::new('validationDate','Date de validation') ;
        $reference = TextField::new('reference', 'Réference') ;
        $comments = TextEditorField::new('comments', 'Commentaires')
            ->setTemplatePath('admin/fields/text_editor.html.twig') ;
        $user = AssociationField::new('user','Utilisateur') ;
        $parts = AssociationField::new('quotationParts','Pièces détachées') ;
        $formattedParts = CollectionField::new('quotationParts','Pièces détachées')
            ->setTemplatePath('admin/fields/list.html.twig')
             ;

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $user, $reference, $creationDate, $validationDate, $comments, $parts, $status] ;
        }
        elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$user, $reference, $creationDate, $validationDate, $comments, $status, $formattedParts] ;
        }
        else {

        }
    }

    public function configureActions(Actions $actions): Actions
    {

        $answer = Action::new('answerQuotation','Répondre au devis')
            ->displayAsLink()
            ->linkToCrudAction('answerQuotation')
            ;

        return $actions
            ->disable(Action::SAVE_AND_CONTINUE)
            ->disable(Action::SAVE_AND_ADD_ANOTHER)
            ->disable(Action::NEW)
            ->disable(Action::EDIT)
            ->disable(Action::DELETE)
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            // ->add(Crud::PAGE_DETAIL, $answer)
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
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setIcon('fa-regular fa-trash-alt me-1 text-danger')
                    ->setLabel('Supprimer')
                    ->displayIf(static function ($entity) {
                        return false ;
                    }) ;
            }) 
            ;
    }

    public function answerQuotation(AdminContext $context) {
        $order = $context->getEntity()->getInstance();
        dd($order) ;
    }
    
}
