<?php

namespace App\Form;

use App\Entity\Player;
use App\Entity\DemonBase;
use App\Entity\DemonTrait;
use App\Entity\DemonPlayer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DemonPlayerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $player = $options['player'];
        $builder
            ->add('str_points', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => "Number of STR  points *",
                'constraints' => [
            new NotBlank()]
                ])
            ->add('end_points', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => "Number of END points *",
                'constraints' => [
            new NotBlank()]
                ])
            ->add('agi_points', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => "Number of AGI points *",
                'constraints' => [
            new NotBlank()]
                ])
            ->add('int_points', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => "Number of INT points *",
                'constraints' => [
            new NotBlank()]
                ])
            ->add('lck_points', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => "Number of LCK points *",
                'constraints' => [
            new NotBlank()]
                ])
            ->add('Experience', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => "Number of EXP points *",
                'constraints' => [
            new NotBlank()]
                ])
            ->add('LvlUp_Points', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => "Number of LvlUP points *",
                'constraints' => [
            new NotBlank()]
                ])
            ->add('player' , EntityType::class, [
                'class'  => Player::class,
                'choice_label' => 'username',
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Player *',
                'data' => $player, // Set the default value to the current player
            ])
            ->add('trait', EntityType::class, [
                'class'  => DemonTrait::class,
                'choice_label' => 'name',
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Trait *',
            ])
            ->add('demon_base', EntityType::class, [
                'class'  => DemonBase::class,
                'choice_label' => 'name',
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Demon Base template *',
            ])
            ->add('Validate', SubmitType::class, [
                'row_attr' => ['class' => 'formRow'],
                'attr' => ['class' => 'btn-11 custom-btn']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemonPlayer::class,
            'player' => null, // Add this line
        ]);
    }
}
