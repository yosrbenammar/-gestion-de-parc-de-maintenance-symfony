<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DemandeInterventionRepository")
 */
class DemandeIntervention
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected  $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected  $date;

    /**
     * @ORM\Column(type="string", length=255)
     * * *@Assert\Length(min=3,max=255, minMessage="l a description  est trop court");

     */
    protected  $description;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Machine", inversedBy="demandeInterventions")
     * @ORM\JoinColumn(nullable=false)
     */
    protected  $machine;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Technicien",cascade={"persist"}, inversedBy="demandes")
     * @ORM\JoinColumn(onDelete="cascade")
     */
    private $techniciens;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SousTraitant")
     */
    private $sousTraitant;


    public function __construct()
    {
        $this->techniciens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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

    /**
     * @return Collection|Technicien[]
     */
    public function getTechniciens(): Collection
    {
        return $this->techniciens;
    }

    public function addTechnicien(Technicien $technicien): self
    {
        if (!$this->techniciens->contains($technicien)) {
            $this->techniciens[] = $technicien;
        }

        return $this;
    }

    public function removeTechnicien(Technicien $technicien): self
    {
        if ($this->techniciens->contains($technicien)) {
            $this->techniciens->removeElement($technicien);
        }

        return $this;
    }

    public function getSousTraitant(): ?SousTraitant
    {
        return $this->sousTraitant;
    }

    public function setSousTraitant(?SousTraitant $sousTraitant): self
    {
        $this->sousTraitant = $sousTraitant;

        return $this;
    }


}
