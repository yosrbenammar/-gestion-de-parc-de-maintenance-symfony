<?php

namespace App\Form;
use App\Entity\SousTraitant;
use App\Entity\Technicien;
use App\Entity\Machine;
use App\Entity\DemandeIntervention;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Doctrine\ORM\EntityRepository;



class DemandeInterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description',TextType::class)
            ->add('machine', EntityType::class, [
                'class' => Machine::class,
                'placeholder' => '---- Aucun ----',
                'choice_label' => 'libelle',
                'attr' => [
                    'class' => 'select2'
                ],
               ])
            ->add('techniciens', EntityType::class, [
                'class' => Technicien::class,
                'placeholder' => 'Sélection multiple ...',
                'choice_label' => function ($tc) {
                    return  $tc->getnom() .' '.$tc->getprenom();}
                    ,'multiple'=> true ,
                    'required' => false ,
                'attr' => [
                        'class' => 'select2'
                    ],
                'mapped'=>false
                 ])
            ->add('sousTraitant', EntityType::class, [
                'class' => SousTraitant::class,
                'placeholder' => '---- Aucun ----',
                'choice_label' => 'nom',
                'required' => false,
                'attr' => [
                    'class' => 'select2'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeIntervention::class,
        ]);
    }
}





