<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ItemFormType extends AbstractType
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
        ->add('category' , ChoiceType::class, [
            'choices'  => [
                'Healing' => 'Healing',
                'Key item' => 'Key Item',
                'Misc' => 'Misc',
            ],
            'row_attr' => ['class' => 'formRow'],
            'label' => 'Damage Type *',
        ])
        ->add('cost', NumberType::class,
        [
            'row_attr' => ['class' => 'formRow'],
            'label' => 'Cost of the item *',
            'constraints' => [
        new NotBlank()]
            ])
        ->add('Validate', SubmitType::class, [
            'row_attr' => ['class' => 'formRow'],
            'attr' => ['class' => 'btn-11 custom-btn']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
