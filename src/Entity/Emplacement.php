<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EmplacementRepository")
 */
class Emplacement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * * *@Assert\Length(min=1,max=255, minMessage="le nom est trop court");

     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HistoriqueEmplacement", mappedBy="emplacement", orphanRemoval=true)
     */
    private $historique;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Machine", mappedBy="emplacement")
     */
    private $machines;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $batiment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->historique = new ArrayCollection();
        $this->machines = new ArrayCollection();
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

    /**
     * @return Collection|historiqueEmplacement[]
     */
    public function getHistorique(): Collection
    {
        return $this->historique;
    }

    public function addHistorique(historiqueEmplacement $historique): self
    {
        if (!$this->historique->contains($historique)) {
            $this->historique[] = $historique;
            $historique->setEmplacement($this);
        }

        return $this;
    }

    public function removeHistorique(historiqueEmplacement $historique): self
    {
        if ($this->historique->contains($historique)) {
            $this->historique->removeElement($historique);
            // set the owning side to null (unless already changed)
            if ($historique->getEmplacement() === $this) {
                $historique->setEmplacement(null);
            }
        }

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
            $machine->setEmplacement($this);
        }

        return $this;
    }

    public function removeMachine(Machine $machine): self
    {
        if ($this->machines->contains($machine)) {
            $this->machines->removeElement($machine);
            // set the owning side to null (unless already changed)
            if ($machine->getEmplacement() === $this) {
                $machine->setEmplacement(null);
            }
        }

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getBatiment(): ?string
    {
        return $this->batiment;
    }

    public function setBatiment(string $batiment): self
    {
        $this->batiment = $batiment;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }





}
