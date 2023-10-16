<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EmailChangeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', RepeatedType::class,
            [
                'type' => TextType::Class,
                'invalid_message' => 'Please enter a valid email address',
                'options' => [
                    'attr' => ['class' => 'email-field'],
                    'row_attr' => ['class' => 'formRow'], //This allows us to have class on our formRow and we don't have to write widget/labels/etc
                ],
                'required' => true,
                'first_options' =>['label' => 'Your new Email'],
                'second_options' => ['label' => 'Confirm your new email'],
                'mapped' => false,
                'constraints' => [
            new NotBlank()]
                ])

            ->add('Validate', SubmitType::class, [
                'row_attr' => ['class' => 'formRow'],
                'attr' => ['class' => 'btn-11 custom-btn']
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token', 
            'csrf_token_id' => 'your_csrf_token_id',
        ]);
    }
}
