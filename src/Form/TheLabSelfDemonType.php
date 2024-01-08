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
use Symfony\Component\Validator\Constraints\Valid;
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
                'help' => 'Type a number between 1 and 100',
                'row_attr' => ['class' => 'formRow'],
                'constraints' => 
                [
                    new Valid(),
                    new Range(['min' => 1, 'max'=> 100]),
                    new NotBlank(),
                ],
                'attr' => ['placeholder' => 'Level']
            ])
            ->add('str', NumberType::class, 
            ['label'=> 'STR',
            'attr' => ['placeholder' => $options['firstD']->getStrDemonBase()],
            'row_attr' => ['class' => 'formRow']])
            ->add('end', NumberType::class, 
            ['label'=> 'END',
            'attr' => ['placeholder' => $options['firstD']->getEndDemonBase()],           
            'row_attr' => ['class' => 'formRow']])
            ->add('agi', NumberType::class, 
            ['label'=> 'AGI',
            'attr' => ['placeholder' => $options['firstD']->getAgiDemonBase()],
            'row_attr' => ['class' => 'formRow']])
            ->add('int', NumberType::class, 
            ['label'=> 'INT',
            'attr' => ['placeholder' => $options['firstD']->getIntDemonBase()],
            'row_attr' => ['class' => 'formRow']])
            ->add('lck', NumberType::class, 
            ['label'=> 'LUCK',
            'attr' => ['placeholder' => $options['firstD']->getLckDemonBase()],
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

            // --------------------CPU--------------------------------------------------
            ->add('demonBaseCPU', EntityType::class, [
                'row_attr' => ['class' => 'formRow'],
                'class'  => DemonBase::class,
                'choice_label' => 'name',
                'required' => false,
                'label' => 'Choose the opponent demon',
                'query_builder' => function (DemonBaseRepository $dbr) {
                    return $dbr->createQueryBuilder('d')
                        ->orderBy('d.name', 'ASC');
                },
            ])
            ->add('levelCPU', NumberType::class,
            [   
                'label' => 'Type the level of the opponent demon',
                'required' => 'true',
                'help' => 'Type a number between 1 and 100',
                'required' => false,
                'row_attr' => ['class' => 'formRow'],
                'constraints' => 
                [
                    new Valid(),
                    new Range(['min' => 1, 'max'=> 100]),
                ],
                'attr' => ['placeholder' => 'Level']
            ])

            ->add('traitCPU', EntityType::class, 
            [
                'class' => DemonTrait::class,
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Pick the opponent trait',
                'required' => false,
                'choice_label' => 'name',
                'query_builder' => function (DemonTraitRepository $dtr) {
                    return $dtr->createQueryBuilder('d')
                        ->orderBy('d.name', 'ASC');
                },
            ])

            ->add('strCPU', NumberType::class, 
            ['label'=> 'STR',
            'required' => false,
            'attr' => ['placeholder' => $options['firstD']->getStrDemonBase()],
            'row_attr' => ['class' => 'formRow']])
            ->add('endCPU', NumberType::class, 
            ['label'=> 'END',
            'required' => false,
            'attr' => ['placeholder' => $options['firstD']->getEndDemonBase()],           
            'row_attr' => ['class' => 'formRow']])
            ->add('agiCPU', NumberType::class, 
            ['label'=> 'AGI',
            'required' => false,
            'attr' => ['placeholder' => $options['firstD']->getAgiDemonBase()],
            'row_attr' => ['class' => 'formRow']])
            ->add('intCPU', NumberType::class, 
            ['label'=> 'INT',
            'required' => false,
            'attr' => ['placeholder' => $options['firstD']->getIntDemonBase()],
            'row_attr' => ['class' => 'formRow']])
            ->add('lckCPU', NumberType::class, 
            ['label'=> 'LUCK',
            'required' => false,
            'attr' => ['placeholder' => $options['firstD']->getLckDemonBase()],
            'row_attr' => ['class' => 'formRow']])

            //----------------------------------------------------------------------------
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
            'firstD' => null,
        ]);
    }
}
