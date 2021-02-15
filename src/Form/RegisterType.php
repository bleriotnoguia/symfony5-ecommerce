<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Your first name',
                'constraints' => new Length(null, 2, 30),
                'attr' => [
                    'placeholder' => 'Please enter your first name'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Your name',
                'constraints' => new Length(null, 2, 30),
                'attr' => [
                    'placeholder' => 'Please enter your name'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Your email',
                'constraints' => new Length(null, 2, 60),
                'attr' => [
                    'placeholder' => 'Please enter your email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Password and confirm password don't match",
                'label' => 'Your password',
                'required' => true,
                'first_options' => [
                    'label' => 'Your password',
                    'attr' => [
                        'placeholder' => 'Please enter your password'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirm your password',
                    'attr' => [
                        'placeholder' => 'Please confirm your password'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sign up',
                'attr' => [
                    'class' => 'btn-info btn-lg btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
