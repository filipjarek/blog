<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tag::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Post Tag')
            ->setEntityLabelInPlural('Post Tags');
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('name');
        yield SlugField::new('slug')
            ->setTargetFieldName('name')
            ->setUnlockConfirmationMessage(
            'It is highly recommended to use the automatic slugs, but you can customize them'
        );
        $createdAt = DateTimeField::new('createdAt')
            ->setTimezone('Europe/Warsaw')
            ->setFormat('short', 'medium');
                if (Crud::PAGE_EDIT === $pageName) {
                    yield $createdAt
                        ->setFormTypeOption('disabled', true);
                } else {
                    yield $createdAt;
                }
        yield DateTimeField::new('updatedAt')
            ->hideONForm()
            ->setTimezone('Europe/Warsaw')
            ->setFormat('short', 'medium');
        yield AssociationField::new('posts')
            ->onlyOnIndex();
    }
}
