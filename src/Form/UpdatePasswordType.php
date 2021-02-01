<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Your email'
            ])
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Your firstname'
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Your name'
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Current password',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Enter your current password'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => "Password and confirm password don't match",
                'label' => 'Your new password',
                'required' => true,
                'first_options' => [
                    'label' => 'Your new password',
                    'attr' => [
                        'placeholder' => 'Please enter your new password'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirm your new password',
                    'attr' => [
                        'placeholder' => 'Please confirm your new password'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Update'
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
