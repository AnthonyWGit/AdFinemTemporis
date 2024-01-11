<?php

namespace App\Form;

use App\Entity\Suggestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SuggestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['row_attr' => ['class' => 'formRow']])
            ->add('postContent', TextareaType::class, ['row_attr' => ['class' => 'formRow']])
            ->add('img', FileType::class, [
                'row_attr' => ['class' => 'formRow'],
                'required' => false,
                'label' => 'Img (JPEG/JPG/PNG)',
                                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ]),
                    new Image([
                        'maxWidth' => 600,
                        'maxHeight' => 600,
                        ]
                    )
                ],
            ])
            ->add('Validate', SubmitType::class, [
                'row_attr' => ['class' => 'formRow'],
                'attr' => ['class' => 'btn-11 custom-btn']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Suggestion::class,
        ]);
    }
}
