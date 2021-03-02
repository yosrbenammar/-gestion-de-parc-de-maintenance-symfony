<?php

namespace App\Form;

use App\Entity\Curative;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\DemandeIntervention;
use App\Entity\PieceRechange;
use App\Entity\Vehicule;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FicheDemontageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('Intervention', EntityType::class, [
                'class' => Curative::class,
                'placeholder' => '---- Aucun ----',
                'choice_label' => function ($Curative) {
                    $m=$Curative->getDemandeIntervention();
                    return 'intervention n:' .$Curative->getid() .' machine: '.$m->getMachine()->getLibelle();
                },
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
            // Configure your form options here
        ]);
    }
}
