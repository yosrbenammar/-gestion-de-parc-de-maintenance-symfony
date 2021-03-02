<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehiculeRepository")
 */
class Vehicule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
  protected $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected  $matricule;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected  $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Intervention", mappedBy="vehicule")
     */
    protected  $interventions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Preventive", mappedBy="vehicule")
     */
    private $preventives;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Curative", mappedBy="vehicule")
     */
    private $curatives;

    public function __construct()
    {
        $this->interventions = new ArrayCollection();
        $this->preventives = new ArrayCollection();
        $this->curatives = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Intervention[]
     */
    public function getInterventions(): Collection
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): self
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions[] = $intervention;
            $intervention->setVehicule($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): self
    {
        if ($this->interventions->contains($intervention)) {
            $this->interventions->removeElement($intervention);
            // set the owning side to null (unless already changed)
            if ($intervention->getVehicule() === $this) {
                $intervention->setVehicule(null);
            }
        }

        return $this;
    }

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
            $preventive->setVehicule($this);
        }

        return $this;
    }

    public function removePreventive(Preventive $preventive): self
    {
        if ($this->preventives->contains($preventive)) {
            $this->preventives->removeElement($preventive);
            // set the owning side to null (unless already changed)
            if ($preventive->getVehicule() === $this) {
                $preventive->setVehicule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Curative[]
     */
    public function getCuratives(): Collection
    {
        return $this->curatives;
    }

    public function addCurative(Curative $curative): self
    {
        if (!$this->curatives->contains($curative)) {
            $this->curatives[] = $curative;
            $curative->setVehicule($this);
        }

        return $this;
    }

    public function removeCurative(Curative $curative): self
    {
        if ($this->curatives->contains($curative)) {
            $this->curatives->removeElement($curative);
            // set the owning side to null (unless already changed)
            if ($curative->getVehicule() === $this) {
                $curative->setVehicule(null);
            }
        }

        return $this;
    }
}
