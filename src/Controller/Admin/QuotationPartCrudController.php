<?php

namespace App\Controller\Admin;

use App\Entity\QuotationPart;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class QuotationPartCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return QuotationPart::class;
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
