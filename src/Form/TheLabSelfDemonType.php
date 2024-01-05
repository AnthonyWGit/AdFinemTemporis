<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Category;
use App\Entity\DemonBase;
use App\Entity\DemonTrait;
use App\Repository\SkillRepository;
use App\Repository\DemonBaseRepository;
use App\Repository\DemonTraitRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TheLabSelfDemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('demonBase', EntityType::class, [
                    'row_attr' => ['class' => 'formRow'],
                    'class'  => DemonBase::class,
                    'choice_label' => 'name',
                    'label' => 'Choose your demon*',
                    'query_builder' => function (DemonBaseRepository $dbr) {
                        return $dbr->createQueryBuilder('d')
                            ->orderBy('d.name', 'ASC');
                    },
                ])
            ->add('level', NumberType::class,
            [   
                'label' => 'Type the level of the demon*',
                'required' => 'true',
                'row_attr' => ['class' => 'formRow'],
                'constraints' => 
                [
                    new Range(['min' => 1, 'max'=> 100]),
                    new NotBlank(),
                ]
            ])
            ->add('str', NumberType::class, 
            ['label'=> 'STR',
            'row_attr' => ['class' => 'formRow']])
            ->add('end', NumberType::class, 
            ['label'=> 'END',
            'row_attr' => ['class' => 'formRow']])
            ->add('agi', NumberType::class, 
            ['label'=> 'AGI',
            'row_attr' => ['class' => 'formRow']])
            ->add('int', NumberType::class, 
            ['label'=> 'INT',
            'row_attr' => ['class' => 'formRow']])
            ->add('lck', NumberType::class, 
            ['label'=> 'LUCK',
            'row_attr' => ['class' => 'formRow']])
            ->add('trait', EntityType::class, 
            [
                'class' => DemonTrait::class,
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Pick your trait*',
                'choice_label' => 'name',
                'query_builder' => function (DemonTraitRepository $dtr) {
                    return $dtr->createQueryBuilder('d')
                        ->orderBy('d.name', 'ASC');
                },
            ])
            ->add("skill", EntityType::class, 
            [
                'class' => Skill::class,
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Pick your skill*',
                'choice_label' => 'name',
                'query_builder' => function (SkillRepository $sr) {
                    return $sr->createQueryBuilder('d')
                        ->orderBy('d.name', 'ASC');
                },
            ])
            ->add('validate', SubmitType::class, [
                'row_attr' => ['class' => 'formRow'],
                'attr' => ['class' => 'btn-11 custom-btn']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'attr' =>
            ['class' => 'center gap'],
        ]);
    }
}
