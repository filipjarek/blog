<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('fullName', TextType::class, [
            'attr' => [
                'placeholder' => 'Your Name',
            ],
            'label_attr' => [
                'class' => 'form-label block text-sm font-medium text-gray-900'
            ],

        ])
        ->add('email', EmailType::class, [
            'attr' => [
                'placeholder' => 'Your email',
            ],
            'label_attr' => [
                'class' => 'form-label block text-sm font-medium text-gray-900'
            ],
          
        ]) 
        ->add('subject', TextType::class, [
            'attr' => [
                'placeholder' => 'Your subject',
            ],
            'label_attr' => [
                'class' => 'form-label block text-sm font-medium text-gray-900'
            ],

        ])
        ->add('message', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Leave a message...',
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
            'data_class' => Contact::class,
        ]);
    }
}