<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SousFamilleRepository")
 */
class SousFamille
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Machine", mappedBy="sousFamille")
     */
    private $famille;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Famille", inversedBy="sousfamille")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fam;

    public function __construct()
    {
        $this->famille = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }


    /**
     * @return Collection|Machine[]
     */
    public function getMachines(): Collection
    {
        return $this->machines;
    }

    public function addMachine(Machine $machine): self
    {
        if (!$this->machines->contains($machine)) {
            $this->machines[] = $machine;
            $machine->setSousFamille($this);
        }

        return $this;
    }

    public function removeMachine(Machine $machine): self
    {
        if ($this->machines->contains($machine)) {
            $this->machines->removeElement($machine);
            // set the owning side to null (unless already changed)
            if ($machine->getSousFamille() === $this) {
                $machine->setEmplacement(null);
            }
        }
    }
    public function getFamille(): Collection
    {
        return $this->famille;
    }

    public function addFamille(machine $famille): self
    {
        if (!$this->famille->contains($famille)) {
            $this->famille[] = $famille;
            $famille->setSousFamille($this);
        }

        return $this;
    }

    public function removeFamille(machine $famille): self
    {
        if ($this->famille->contains($famille)) {
            $this->famille->removeElement($famille);
            // set the owning side to null (unless already changed)
            if ($famille->getSousFamille() === $this) {
                $famille->setSousFamille(null);
            }
        }

        return $this;
    }

    public function getFam(): ?Famille
    {
        return $this->fam;
    }

    public function setFam(?Famille $fam): self
    {
        $this->fam = $fam;

        return $this;
    }
}
