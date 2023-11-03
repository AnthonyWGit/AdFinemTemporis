<?php

namespace App\Form;

use App\Entity\Skill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SkillFormType extends AbstractType
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
            ->add('baseDmg', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Base Damage *',
                'constraints' => [
            new NotBlank()]
                ])
            ->add('description', TextareaType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Description *',
                'constraints' => [
            new NotBlank()]
                ])
            ->add('dmgType', ChoiceType::class, [
                'choices'  => [
                    'Phys' => 'phys',
                    'Mag' => 'mag',
                    'Int' => 'int',
                    'Str/Agi' => 'str/agi',
                    'Int Pure' => 'int pure',
                ],
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Damage Type *',
            ])
            ->add('Validate', SubmitType::class, [
                'row_attr' => ['class' => 'formButton'],
                'attr' => ['class' => 'btn-11 custom-btn']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Skill::class,
        ]);
    }
}
