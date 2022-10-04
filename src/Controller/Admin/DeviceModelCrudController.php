<?php

namespace App\Controller\Admin;

use App\Entity\DeviceModel;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
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

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('designation'),
            AssociationField::new('deviceType', 'Type de matériel'),
            BooleanField::new('active', 'Actif')
                ->setTemplatePath('admin/fields/active_field.html.twig')
                ->onlyOnIndex(),
            BooleanField::new('active', 'Actif')->onlyOnForms(),
        ];
    }
}
