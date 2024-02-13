<?php

namespace App\Form;

use App\Entity\DemonBase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DemonBaseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class,
        [
            'row_attr' => ['class' => 'formRow'],
            'label' => 'Name *',
            'constraints' => [
        new NotBlank()]
            ])
        ->add('pantheon', TextType::class,
        [
            'row_attr' => ['class' => 'formRow'],
            'label' => 'Pantheon *',
            'constraints' => [
        new NotBlank()]
            ])
        ->add('baseHp', NumberType::class,
        [
            'row_attr' => ['class' => 'formRow'],
            'label' => 'Base HP *',
            'constraints' => [
        new NotBlank()]
            ])
        ->add('lore', TextareaType::class,
        [
            'row_attr' => ['class' => 'formRow'],
            'label' => 'Lore',
            'required'=> false,
            ])
        ->add('str_demon_base', NumberType::class,
        [
            'row_attr' => ['class' => 'formRow'],
            'label' => "Base STR *",
            'constraints' => [
        new NotBlank()]
            ])
        ->add('end_demon_base', NumberType::class,
        [
            'row_attr' => ['class' => 'formRow'],
            'label' => "Base END *",
            'constraints' => [
        new NotBlank()]
            ])
        ->add('agi_demon_base', NumberType::class,
        [
            'row_attr' => ['class' => 'formRow'],
            'label' => "Base AGI *",
            'constraints' => [
        new NotBlank()]
            ])
        ->add('int_demon_base', NumberType::class,
        [
            'row_attr' => ['class' => 'formRow'],
            'label' => "Base INT *",
            'constraints' => [
        new NotBlank()]
            ])
        ->add('lck_demon_base', NumberType::class,
        [
            'row_attr' => ['class' => 'formRow'],
            'label' => "Base LCK *",
            'constraints' => [
        new NotBlank()]
            ])
        ->add('img', FileType::class, [
            'data_class' => null,
            'required' => false,
            'label' => 'Img (JPEG/JPG/PNG)',
            'row_attr' => ['class' => 'formRow'],
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid document',
                ])
            ],
        ])
        ->add('Validate', SubmitType::class, [
            'row_attr' => ['class' => 'formRow'],
            'attr' => ['class' => 'btn-11 custom-btn']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemonBase::class,
        ]);
    }
}
