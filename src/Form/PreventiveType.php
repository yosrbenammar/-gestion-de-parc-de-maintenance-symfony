<?php

namespace App\Form;
// src/OC/PlatformBundle/Form/AdvertType.php

use App\Entity\Machine;
use App\Entity\PieceRechange;
use App\Entity\Preventive;
use App\Entity\SousTraitant;
use App\Entity\Technicien;
use App\Entity\Vehicule;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PreventiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class)
            ->add('desription',TextareaType::class)
            ->add('technicien', EntityType::class, [
                'class' => Technicien::class,
                'placeholder' => 'Sélection multiple ...',
                'choice_label' => function($tc){
                    return $tc->getPrenom() . ' ' . $tc->getNom();
                },
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'class' => 'select2'
                ]
            ])

            ->add('dateFin',DateType::class)
            ->add('machine', EntityType::class, [
                'class' => Machine::class,
                'placeholder' => '---- Aucun ----',
                'choice_label' => 'libelle',
                'attr' => [
                    'class' => 'select2'
                ]
            ])
            ->add('vehicule', EntityType::class, [
                'class' => Vehicule::class,
                'placeholder' => '---- Aucun ----',
                'choice_label' => 'matricule',
                'required' => false,
                'attr' => [
        'class' => 'select2'
    ]
            ])
            ->add('sousTraitant', EntityType::class, [
                'class' => SousTraitant::class,
                'placeholder' => '---- Aucun ----',
                'choice_label' => 'nom',
               'required' => false,
                'attr' => [
        'class' => 'select2'
    ]
            ])



        ->add('dateFin',DateType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Preventive::class,
        ]);
    }
}
