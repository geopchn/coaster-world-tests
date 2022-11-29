<?php

namespace App\Form;

use App\Entity\Park;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom',
            ])
            ->add('imageFile', null, [
                'label' => 'Image'
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de parc',
                'choices' => array_flip(Park::TYPES),
                'placeholder' => 'Séléctionner le type du parc',
            ])
            ->add('website', UrlType::class, [
                'label' => 'Site Web'
            ])
            ->add('address', AddressType::class, [
                'label' => 'Adresse',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Park::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
