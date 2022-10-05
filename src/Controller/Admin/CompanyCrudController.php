<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('companyName', 'Nom de la société'),
            TextField::new('siret', 'SIRET'),
            TextField::new('address', 'Adresse'),
            TextField::new('additionalAddress', 'Complément d\'adresse'),
            TextField::new('postalCode', 'Code postal'),
            TextField::new('city','Ville'),
            BooleanField::new('active', 'Actif')
                ->setTemplatePath('admin/fields/active_field.html.twig')
                ->onlyOnIndex(),
            BooleanField::new('active', 'Actif')->onlyOnForms(),
        ];
    }
}
