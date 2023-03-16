<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('category');
        yield TextField::new('title');
        yield SlugField::new('slug')->setTargetFieldName('title')->setUnlockConfirmationMessage(
            'It is highly recommended to use the automatic slugs, but you can customize them'
        );
        yield TextareaField::new('previewContent')->onlyOnForms();
        yield TextareaField::new('content')->onlyOnForms();
        yield DateField::new('created_at')->hideOnForm();
        yield BooleanField::new('is_active');
    }
}
