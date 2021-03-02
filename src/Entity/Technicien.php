<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 21/05/2020
 * Time: 15:06
 */

namespace App\Entity;
use App\Entity\Traits\EmployeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TechnicienRepository")
 *@UniqueEntity("tel",message="Il existe déjà un employée ayant ce  numéro!!")
 */
class Technicien

{ use EmployeTrait;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Preventive", cascade={"persist"}, mappedBy="technicien")
     */
    private $preventives;



    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DemandeIntervention",cascade={"persist"}, mappedBy="techniciens")
     */
    private $demandes;

    private $chef;

    public function __construct()
    {

        $this->preventives = new ArrayCollection();
        $this->demandes = new ArrayCollection();

    }

    /***** Getters and setters *****/



    /**
     * @return Collection|Preventive[]
     */
    public function getPreventives(): Collection
    {
        return $this->preventives;
    }

    public function addPreventive(Preventive $preventive): self
    {
        if (!$this->preventives->contains($preventive)) {
            $this->preventives[] = $preventive;
            $preventive->addTechnicien($this);
        }

        return $this;
    }

    public function removePreventive(Preventive $preventive): self
    {
        if ($this->preventives->contains($preventive)) {
            $this->preventives->removeElement($preventive);
            $preventive->removeTechnicien($this);
        }

        return $this;
    }

    /**
     * @return Collection|DemandeIntervention[]
     */

    public function addDemande(DemandeIntervention $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->addTechnicien($this);
        }

        return $this;
    }

    public function removeDemande(DemandeIntervention $demande): self
    {
        if ($this->demandes->contains($demande)) {
            $this->demandes->removeElement($demande);
            $demande->removeTechnicien($this);
        }

        return $this;
    }




}

