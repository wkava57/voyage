<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Doctrine\ORM\Mapping\Id;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PhpParser\Node\Expr\BinaryOp\Identical;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->setFormTypeOption('disabled', true),
            TextField::new('depart'),
            TextField::new('destination'),
            TextField::new('title'),
            SlugField::new('slug')->setTargetFieldName('title'),

            ImageField::new('illustration')
            ->setBasePath('uploads')
            ->setUploadDir('public/uploads')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),

//            voir pour remplacer textField suivant les avantages.
            TextareaField::new('description'),
//            BooleanField::new('isBest'),
            MoneyField::new('price')
                ->setCurrency("EUR")
                ->setNumDecimals(0),


            AssociationField::new('category'),
        ];
    }

}

