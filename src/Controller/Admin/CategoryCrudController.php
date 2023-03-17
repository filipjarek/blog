<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Blog Category')
            ->setEntityLabelInPlural('Blog Categories');
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('name');
        yield SlugField::new('slug')->setTargetFieldName('name')->setUnlockConfirmationMessage(
            'It is highly recommended to use the automatic slugs, but you can customize them'
        );
        $createdAt = DateTimeField::new('createdAt');
                    if (Crud::PAGE_EDIT === $pageName) {
                        yield $createdAt->setFormTypeOption('disabled', true);
                    } else {
                        yield $createdAt;
                    }
        yield BooleanField::new('is_active');
        yield AssociationField::new('posts')->onlyOnIndex();
    }
}
