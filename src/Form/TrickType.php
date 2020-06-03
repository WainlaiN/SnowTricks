<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Trick;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;


class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'Enter the title here',
                    ],
                ]
            )
            ->add(
                'category',
                EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'title',
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'attr' => [
                        'placeholder' => 'Enter your description here',
                    ],
                ]
            )
            ->add(
                'file',
                FileType::class,
                [
                    'required' => false,
                    'mapped' => false,
                    'constraints' => [
                        new Image()
                    ]
                ]
            )
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    //'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'required' => false,
                    'prototype' => true,
                ]
            )
            ->add(
                'videos',
                CollectionType::class,
                [
                    'entry_type' => VideoType::class,
                    //'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'required' => false,
                    'prototype' => true,
                ]
            );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Trick::class,
            ]
        );
    }
}
