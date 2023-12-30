<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\DemonBase;
use App\Entity\SkillTable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SkillTableFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('level', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Level *',
                'constraints' => [
            new NotBlank()]
                ])
            ->add('skill', EntityType::class, [
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Skill name *',
                'constraints' => [
                    new NotBlank()],
                'class' => Skill::class,
'choice_label' => 'name',
            ])
            ->add('demonBase', EntityType::class, [
                'row_attr' => ['class' => 'formRow'],
                'class' => DemonBase::class,
                'constraints' => [
                    new NotBlank()],
                'label' => 'Demon name *',
'choice_label' => 'name',
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
            'data_class' => SkillTable::class,
        ]);
    }
}
