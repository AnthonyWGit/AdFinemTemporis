<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Player;
use App\Entity\HaveItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HaveItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', NumberType::class,
            [
                'row_attr' => ['class' => 'formRow'],
                'label' => "Quantity *",
                'constraints' => [
            new NotBlank()]
                ])
            ->add('player' , EntityType::class, [
                'class'  => Player::class,
                'choice_label' => 'username',
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Player *',
            ])
            ->add('item' , EntityType::class, [
                'class'  => Item::class,
                'choice_label' => 'name',
                'row_attr' => ['class' => 'formRow'],
                'label' => 'Item *',
            ])
            ->add('Validate', SubmitType::class, [
                'row_attr' => ['class' => 'formRow'],
                'attr' => ['class' => 'btn-11 custom-btn']
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HaveItem::class,
        ]);
    }
}
