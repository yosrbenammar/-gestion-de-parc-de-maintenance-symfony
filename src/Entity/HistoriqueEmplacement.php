<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoriqueEmplacementRepository")
 */
class HistoriqueEmplacement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateChangement;
    /**
     * @ORM\Column(type="object", nullable=true)
     */
    private $emplacement;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Machine", inversedBy="historiqueEmplacements")
     */
    private $machine;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateChangement(): ?\DateTimeInterface
    {
        return $this->dateChangement;
    }

    public function setDateChangement(?\DateTimeInterface $dateChangement): self
    {
        $this->dateChangement = $dateChangement;

        return $this;
    }




    public function getEmplacement(): ?Emplacement
    {
        return $this->emplacement;
    }

    public function setEmplacement(?Emplacement $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getMachine(): ?machine
    {
        return $this->machine;
    }

    public function setMachine(?machine $machine): self
    {
        $this->machine = $machine;

        return $this;
    }
}
