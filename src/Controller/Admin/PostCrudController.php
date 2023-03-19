<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Blog Post')
            ->setEntityLabelInPlural('Blog Posts')
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('category'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield AssociationField::new('category');
        yield AssociationField::new('tags')
            ->setFormTypeOption('choice_label', 'name');
        yield TextField::new('title');
        yield SlugField::new('slug')
            ->setTargetFieldName('title')
            ->setUnlockConfirmationMessage(
            'It is highly recommended to use the automatic slugs, but you can customize them'
        );
        yield TextareaField::new('previewContent')
            ->onlyOnForms();
        yield TextEditorField::new('content')
            ->onlyOnForms();
       
        yield ImageField::new('image')
            ->setBasePath('uploads/images')
            ->setUploadDir('public/uploads/images/');
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
        yield BooleanField::new('is_active');
        yield AssociationField::new('comments')
            ->onlyOnIndex();
    }
}
