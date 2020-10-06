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
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;


/**
 * Class TrickType
 *
 * @package App\Form
 */
class TrickType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $trick = $options['data'] ?? null;
        $isEdit = $trick && $trick->getId();

        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'Nom de la figure',
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
                        'placeholder' => 'Description du trick',
                    ],
                ]
            );

        $imageConstraints = [
            new Image(
                [
                    'maxSize' => '5M',
                ]
            ),
        ];
        if (!$isEdit) {
            $imageConstraints[] = new NotNull(
                [
                    'message' => 'Veuillez choisir une image principale',
                ]
            );
        }

        $builder
            ->add(
                'file',
                FileType::class,
                [
                    'mapped' => false,
                    'required' => false,
                    'constraints' => $imageConstraints,
                ]
            )
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
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
                    'allow_add' => true,
                    'allow_delete' => true,
                    'required' => false,
                    'prototype' => true,
                ]
            );


    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Trick::class,
            ]
        );
    }
}
