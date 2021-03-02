<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Form\DataTransformer\CollectionToArrayTransformer;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('username')
            ->add('email')
            ->add('password', PasswordType::class)
            ->add('userRoles', ChoiceType::class, array(
                    'choices' => array
                    (
                        'Administrateur' => 'ROLE_ADMIN',
                        'Magasinier' => 'ROLE_MAG',
                        'Technicien' => 'ROLE_TECH'
                    ),
                    'multiple' => false,
                    'required' => true,
                    'mapped' => false,
                )
            );
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
