<?php

namespace App\Controller\Admin;

use App\Entity\SparePart;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SparePartCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SparePart::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
