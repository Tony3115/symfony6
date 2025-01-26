<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add(
                'image',
                FileType::class,
                [
                    'required' => false,
                    'mapped' => false,
                    'label' => "Image Catégorie",
                    'attr' => [
                        'placeholder' => 'Placeholder Image Catégorie'
                    ],
                    'constraint' => [
                        new File([
                            'maxSize' => '1024K',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png'
                            ],
                            'mimeTypeMessage' => 'Merci de charger un fichier jpg ou png',
                            'uploadFormSizeErrorMessage' => 'La taille max autorisée est de 1024 kO',
                        ])
                    ],
                ]
            )
            ->add('date_add', DateTimeType::class, [
                'data' => new \DateTime(),
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
