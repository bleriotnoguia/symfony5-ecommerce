<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Your first name',
                'attr' => [
                    'placeholder' => 'Please enter your first name'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Your name',
                'attr' => [
                    'placeholder' => 'Please enter your name'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Your email',
                'attr' => [
                    'placeholder' => 'Please enter your email'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Your password',
                'attr' => [
                    'placeholder' => 'Please enter your password'
                ]
            ])
            ->add('password_confirm', PasswordType::class, [
                'label' => 'Confirm your password',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Confirm your password'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sign up'
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
