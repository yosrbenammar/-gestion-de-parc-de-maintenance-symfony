<?php

namespace App\Entity;

use App\Entity\Traits\EmployeTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MagasinierRepository")
 *@UniqueEntity("tel",message="Il existe déjà un employée ayant ce  numéro!!")
 */


class Magasinier
{ use EmployeTrait;


}
