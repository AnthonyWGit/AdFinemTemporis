<?php

namespace App\Form;

use App\Entity\DemonTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DemonTraitFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name' , TextType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Name *',
                'constraints' => [
            new NotBlank()]
                ])
            ->add('strength',  NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Strength *',
                'constraints' => [
            new NotBlank()]
                ])
            ->add('endurance', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Endurance *',
                'constraints' => [
            new NotBlank()]
                ])
            ->add('agility',  NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Agility *',
                'constraints' => [
            new NotBlank()]
                ])
            ->add('intelligence', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Intelligence *',
                'constraints' => [
            new NotBlank()]
                ])
            ->add('luck', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Luck *',
                'constraints' => [
            new NotBlank()]
                ])
            ->add('Validate', SubmitType::class, [
                'row_attr' => ['class' => 'formRow'],
                'attr' => ['class' => 'btn-11 custom-btn']
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemonTrait::class,
        ]);
    }
}
