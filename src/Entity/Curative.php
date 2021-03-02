<?php


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
class Curative
{
    use InterventionTrait;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DemandeIntervention", cascade={"persist", "remove"})
     */
    private $demandeIntervention;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicule", inversedBy="curatives")
     */
    private $vehicule;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PiecesPourIntervention",  cascade={"persist", "remove"}, mappedBy="intervention")
     */
    private $piecePourIntervention;

    public function __construct()
    {
        $this->piecePourIntervention = new ArrayCollection();
    }

    public function getDemandeIntervention(): ?DemandeIntervention
    {
        return $this->demandeIntervention;
    }

    public function setDemandeIntervention(?DemandeIntervention $demandeIntervention): self
    {
        $this->demandeIntervention = $demandeIntervention;

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

    /**
     * @return Collection|PiecesPourIntervention[]
     */
    public function getPiecePourIntervention(): Collection
    {
        return $this->piecePourIntervention;
    }

    public function addPiecePourIntervention(PiecesPourIntervention $piecePourIntervention): self
    {
        if (!$this->piecePourIntervention->contains($piecePourIntervention)) {
            $this->piecePourIntervention[] = $piecePourIntervention;
            $piecePourIntervention->setPiecePourIntervention($this);
        }

        return $this;
    }

    public function removePiecePourIntervention(PiecesPourIntervention $piecePourIntervention): self
    {
        if ($this->piecePourIntervention->contains($piecePourIntervention)) {
            $this->piecePourIntervention->removeElement($piecePourIntervention);
            // set the owning side to null (unless already changed)
            if ($piecePourIntervention->getPiecePourIntervention() === $this) {
              $piecePourIntervention->setPiecePourIntervention(null);
           }
        }

        return $this;
    }
}