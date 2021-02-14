<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Your address name',
                'attr' => [
                    'placeholder' => 'Your address name'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Your firstname name',
                'attr' => [
                    'placeholder' => 'Your firstname name'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Your lastname name',
                'attr' => [
                    'placeholder' => 'Your lastname name'
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'Your company name',
                'attr' => [
                    'placeholder' => 'Your company name'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Your address',
                'attr' => [
                    'placeholder' => 'Your address'
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => 'Your postall code',
                'attr' => [
                    'placeholder' => 'Your postall code'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Your city',
                'attr' => [
                    'placeholder' => 'Your city'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'Your country',
                'attr' => [
                    'placeholder' => 'Your country'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Your phone',
                'attr' => [
                    'placeholder' => 'Your phone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
