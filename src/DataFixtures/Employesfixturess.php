<?php

namespace App\DataFixtures;

use App\Entity\Employes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManage;
use Doctrine\Persistence\ObjectManager;



class Employesfixturess extends Fixture
{
    public function load( ObjectManager $manager)
    {
        $employe=new Employes();

        //pour creer un employe

        $employe->setMatricule('0001')
            ->setNom('yosr')
            ->setPrenom('ben ammar')
            ->setAdresse('sfax')
            ->setFonction('ingenieur electrique')
            ->settel('92196807')
            ->setDateNaissance( new\ DateTime())
            ->setDateRecrutement( new\ DateTime());
         $manager->persist($employe);
         $manager->flush();
    }
}
