<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 22/05/2020
 * Time: 13:20
 */

namespace App\Entity;

use App\Entity\Traits\InterventionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
/**
 *  @ORM\Table
 * @ORM\Entity
 */
class Preventive
{
    use InterventionTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Machine", inversedBy="Preventives")
     * @ORM\JoinColumn(nullable=false)
     */
    private $machine;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicule", inversedBy="preventives")
     */
    private $vehicule;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SousTraitant", inversedBy="preventives")
     *  @ORM\JoinColumn( nullable=true)
     */
    private $sousTraitant;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Technicien", inversedBy="preventives")
     */
    private $technicien;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PiecePourinterventionPrevtive", mappedBy="intervention")
     */
    private $piecePourinterventionPrevtives;


    public function __construct()
    {
        $this->technicien = new ArrayCollection();

        $this->piecePourinterventionPrevtives = new ArrayCollection();

    }

    public function getMachine(): ?Machine
    {
        return $this->machine;
    }

    public function setMachine(?Machine $machine): self
    {
        $this->machine = $machine;

        return $this;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getSousTraitant(): ?SousTraitant
    {
        return $this->sousTraitant;
    }

    public function setSousTraitant( $sousTraitant=null): self
    {
        $this->sousTraitant = $sousTraitant;

        return $this;
    }

    /**
     * @return Collection|Technicien[]
     */
    public function getTechnicien(): Collection
    {
        return $this->technicien;
    }

    public function addTechnicien(Technicien $technicien): self
    {
        if (!$this->technicien->contains($technicien)) {
            $this->technicien[] = $technicien;
        }

        return $this;
    }

    public function removeTechnicien(Technicien $technicien): self
    {
        if ($this->technicien->contains($technicien)) {
            $this->technicien->removeElement($technicien);
        }

        return $this;
    }


    /**
     * @return Collection|PiecePourinterventionPrevtive[]
     */
    public function getPiecePourinterventionPrevtives(): Collection
    {
        return $this->piecePourinterventionPrevtives;
    }

    public function addPiecePourinterventionPrevtive(PiecePourinterventionPrevtive $piecePourinterventionPrevtive): self
    {
        if (!$this->piecePourinterventionPrevtives->contains($piecePourinterventionPrevtive)) {
            $this->piecePourinterventionPrevtives[] = $piecePourinterventionPrevtive;
            $piecePourinterventionPrevtive->setIntervention($this);
        }

        return $this;
    }

    public function removePiecePourinterventionPrevtive(PiecePourinterventionPrevtive $piecePourinterventionPrevtive): self
    {
        if ($this->piecePourinterventionPrevtives->contains($piecePourinterventionPrevtive)) {
            $this->piecePourinterventionPrevtives->removeElement($piecePourinterventionPrevtive);
            // set the owning side to null (unless already changed)
            if ($piecePourinterventionPrevtive->getIntervention() === $this) {
                $piecePourinterventionPrevtive->setIntervention(null);
            }
        }

        return $this;
    }


}