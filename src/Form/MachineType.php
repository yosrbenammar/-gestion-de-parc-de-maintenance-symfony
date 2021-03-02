<?php

namespace App\Form;

use App\Entity\Emplacement;
use App\Entity\Machine;
use App\Entity\SousFamille;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MachineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('numeroSerie')
            ->add('etat')
            ->add('dateInstalation')
            ->add('datePrchaineEntretient')
            ->add('sousFamille',SousFamilleType::class, ['data_class' => SousFamille::class])
            ->add('emplacement',EmplacementType::class, ['data_class' => Emplacement::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Machine::class,
        ]);
    }
}
