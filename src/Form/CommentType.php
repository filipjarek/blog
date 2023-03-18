<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('author', TextType::class, [
            'attr' => [
                'placeholder' => 'Your Name',
            ],
            'label_attr' => [
                'class' => 'form-label block text-sm font-medium text-gray-900'
            ],

        ])
        ->add('text', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Leave a comment...',
            ],
            'label_attr' => [
                'class' => 'form-label block text-sm font-medium text-gray-900'
                
            ],
          
        ]) 
        ->add('submit', SubmitType::class, [
            'label' => 'Submit'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}