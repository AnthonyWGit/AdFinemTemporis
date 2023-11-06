<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
        ->add('category' , EntityType::class, [
            'class'  => Category::class,
            'choice_label' => 'name',
            'row_attr' => ['class' => 'formRow'],
            'label' => 'Category*',
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
