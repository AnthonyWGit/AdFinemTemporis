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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('username', TextType::class,
                [
                    'constraints' => [
                new NotBlank()]
                    ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('email', RepeatedType::class,
            [
                'type' => TextType::Class,
                'invalid_message' => 'Please enter a valid email address',
                'options' => [
                    'attr' => ['class' => 'password-field'],
                    'row_attr' => ['class' => 'formRow'], //This allows us to have class on our formRow and we don't have to write widget/labels/etc
                ],
                'required' => true,
                'first_options' =>['label' => 'Email'],
                'second_options' => ['label' => 'Confirm your email'],
                'mapped' => false,
                'constraints' => [
            new NotBlank()]
                ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => [
                    'attr' => ['class' => 'password-field'],
                    'row_attr' => ['class' => 'formRow'], //This allows us to have class on our formRow and we don't have to write widget/labels/etc
                ],
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ["label" => 'Type your password again'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '~^(?=.{12,}$)(?=.*\p{Lu})(?=.*\p{Ll})(?=.*\d)(?=.*[@#$%^&+=!]).*$~',
                        'message' => 'Ce MdP ne correspond pas aux consignes'
                    ]),
                ]
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
