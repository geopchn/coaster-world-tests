<?php

namespace App\Form;

use App\Entity\Coaster;
use App\Entity\Park;
use App\Repository\ManufacturerRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoasterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de l\'attraction',
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image',
            ])
            ->add('openedAt', null, [
                'label' => 'Date d\'inauguration',
                'widget' => 'single_text',
            ])
            ->add('minimumHeight', null, [
                'label' => 'Taille minimum',
                'help' => 'En centimètre',
                'attr' => [
                    'min' => 50,
                    'max' => 230,
                ],
            ])
            ->add('maximumHeight', null, [
                'label' => 'Taille maximum',
                'help' => 'En centimètre',
                'attr' => [
                    'min' => 50,
                    'max' => 230,
                ],
            ])
            ->add('duration', null, [
                'label' => 'Durée d\'un tour',
                'with_seconds' => true,
                'hours' => range(0, 2),
            ])
            ->add('manufacturer', null, [
                'label' => 'Constructeur',
                'placeholder' => 'Séléctionner le constructeur',
                'query_builder' => function(ManufacturerRepository $repository){
                    return $repository->createQueryBuilder('m')
                        ->orderBy('m.name', 'ASC');
                }
            ])
            ->add('tags', null, [
                'label' => 'Catégorie(s)',
                'expanded' => true,
            ])
            ->add('park', null, [
                'label' => 'Parc',
                'choice_label' => 'name',
                'group_by' => function(Park $park){
                    return Park::TYPES[$park->getType()];
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coaster::class, // "App\Entity\Coaster"
        ]);
    }
}
