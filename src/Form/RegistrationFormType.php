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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                    'label'=> 'Username *',
                    'row_attr' => ['class' => 'formRow'],
                    'constraints' => [
                new NotBlank()]
                    ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'row_attr' => ['class' => 'formRow'],
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'label' => 'You agree to our Terms of Service',
                'help' => '<a href="/tos">Terms of Service</a>',
                'help_html' => true
            ])
            ->add('email', RepeatedType::class,
            [
                'type' => TextType::Class,
                'invalid_message' => 'Please enter a valid email address',
                'options' => [
                    'attr' => ['class' => 'email-field'],
                    'row_attr' => ['class' => 'formRow'], //This allows us to have class on our formRow and we don't have to write widget/labels/etc
                ],
                'required' => true,
                'first_options' =>['label' => 'Email *'],
                'second_options' => ['label' => 'Confirm your email *'],
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
                'help' => 'Pwd must be at least 12 chars long, you need at least 1 UC, 1 LC, 1 number, 1 special char',
                'required' => true,
                'first_options' => ['label' => 'Password *'],
                'second_options' => ["label" => 'Type your password again *'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '~^(?=.{12,}$)(?=.*\p{Lu})(?=.*\p{Ll})(?=.*\d)(?=.*[@#$%^&+=!]).*$~',
                        'message' => 'This password is incorrect'
                    ]),
                ]
            ])
            ->add('Validate', SubmitType::class, [
                'row_attr' => ['class' => 'formRow'],
                'attr' => ['class' => 'btn-11 custom-btn']
            ])
            //Honeypot field 
            ->add('SurnameField', HiddenType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'SurnameField',
                    'id' => 'surname-field',
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
