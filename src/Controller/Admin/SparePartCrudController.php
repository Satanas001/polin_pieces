<?php

namespace App\Controller\Admin;

use App\Entity\SparePart;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
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

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('reference', 'Référence'),
            TextField::new('designation', 'Désignation'),
            TextEditorField::new('description'),
            MoneyField::new('unitPrice','Prix unitaire')
                ->setCurrency('EUR')
                ->setNumDecimals(2),
            ImageField::new('image', 'Image')
                ->setBasePath(self::DOCUMENTS_BASE_PATH)
                ->setUploadDir(self::DOCUMENTS_UPLOAD_DIR),
            BooleanField::new('isEnabled','Actif'),
            AssociationField::new('device','Modèle')
        ];
    }
}
