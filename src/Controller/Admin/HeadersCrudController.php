<?php

namespace App\Controller\Admin;

use App\Entity\Headers;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class HeadersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Headers::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title','Titre de Header'),
            TextareaField::new('content','Contenu de Header'),
            TextField::new('btnTitle','Titre du button'),
            TextField::new('btnUrl','Url De destination de button'),
            ImageField::new('illustration')->setBasePath('img/')->setUploadDir('public/img/')
            ->setRequired(false),
        ];
    }

}
