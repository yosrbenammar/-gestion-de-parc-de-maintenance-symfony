<?php

namespace App\Form;

use App\Entity\Curative;
use App\Entity\DemandeIntervention;
use App\Entity\PieceRechange;
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

class CurativeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class)
            ->add('desription',TextareaType::class)
            ->add('demandeIntervention', EntityType::class, [
                'class' => DemandeIntervention::class,
                'placeholder' => '---- Aucun ----',
                'choice_label' => function ($DemandeIntervention) {
                    $m=$DemandeIntervention->getMachine();
                    return 'intervention n: ' .$DemandeIntervention->getid() .' machine: '.$m->getLibelle();
                },
                'attr' => [
                    'class' => 'select2'
                ],
            ])
            ->add('vehicule', EntityType::class, [
                'class' => Vehicule::class,
                'placeholder' => '---- Aucun ----',
                'choice_label' => 'matricule',
                'required' => false,
                'attr' => [
                    'class' => 'select2'
                ],
            ])
            ->add('dateFin',DateType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Curative::class,
        ]);
    }
}
