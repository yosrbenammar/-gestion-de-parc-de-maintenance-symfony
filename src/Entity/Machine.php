<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\MachineRepository")
 *@UniqueEntity("numeroSerie",message="Il existe déjà une machine ayant ce  numéro de série!!")
 */

class Machine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected  $id;

    /**
     * @ORM\Column(type="string", length=50)
     * *@Assert\Length(min=3,max=50, minMessage="libellé est trop court");
     *  @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message=" nom invalide "
     * )
     */
    protected  $libelle;


    /**
     * @ORM\Column(type="integer",unique=true, length=30)
     * @Assert\Length(min=3, minMessage="numéro de serie assez court");
     * )


     **/
    protected  $numeroSerie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected  $etat;

    /**
     * @ORM\Column(type="datetime")
     * *@Assert\LessThan("today" , message="la date d'instalation doit être inférieur a date d'aujoud'hui!")*/
    protected  $dateInstalation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * * @Assert\GreaterThan(propertyPath="dateInstalation" , message="la date du prochine entretient  doit être superieur a date d'instalation!")
     */
    protected  $datePrchaineEntretient;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HistoriqueEmplacement", mappedBy="relation")
     */
    protected  $machine;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SousFamille", inversedBy="famille")
     */
    protected  $sousFamille;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Emplacement", inversedBy="machines_placer")
     */
    protected  $emplacement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HistoriqueEmplacement", mappedBy="machine")
     */
    private $historiqueEmplacements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DemandeIntervention", mappedBy="machine")
     */
    protected $demandeInterventions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Preventive", mappedBy="machine")
     */
    protected  $preventives;

    public function __construct()
    {
        $this->historiqueEmplacements = new ArrayCollection();
        $this->demandeInterventions = new ArrayCollection();
        $this->preventives = new ArrayCollection();
        $this->machine = new ArrayCollection();
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

    public function getNumeroSerie(): ?string
    {
        return $this->numeroSerie;
    }

    public function setNumeroSerie(string $numeroSerie): self
    {
        $this->numeroSerie = $numeroSerie;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDateInstalation(): ?\DateTimeInterface
    {
        return $this->dateInstalation;
    }

    public function setDateInstalation(\DateTimeInterface $dateInstalation): self
    {
        $this->dateInstalation = $dateInstalation;

        return $this;
    }

    public function getDatePrchaineEntretient(): ?\DateTimeInterface
    {
        return $this->datePrchaineEntretient;
    }

    public function setDatePrchaineEntretient(?\DateTimeInterface $datePrchaineEntretient): self
    {
        $this->datePrchaineEntretient = $datePrchaineEntretient;

        return $this;
    }

    /**
     * @return Collection|HistoriqueEmplacement[]
     */
    public function getMachine(): Collection
    {
        return $this->machine;
    }

    public function addMachine(HistoriqueEmplacement $machine): self
    {
        if (!$this->machine->contains($machine)) {
            $this->machine[] = $machine;
            $machine->setRelation($this);
        }

        return $this;
    }

    public function removeMachine(HistoriqueEmplacement $machine): self
    {
        if ($this->machine->contains($machine)) {
            $this->machine->removeElement($machine);
            // set the owning side to null (unless already changed)
            if ($machine->getRelation() === $this) {
                $machine->setRelation(null);
            }
        }

        return $this;
    }

    public function getSousFamille(): ?SousFamille
    {
        return $this->sousFamille;
    }

    public function setSousFamille(?SousFamille $sousFamille): self
    {
        $this->sousFamille = $sousFamille;

        return $this;
    }

    /**
     * @return Collection|historiqueEmplacement[]
     */
    public function getEmp(): Collection
    {
        return $this->emp;
    }

    public function addEmp(historiqueEmplacement $emp): self
    {
        if (!$this->emp->contains($emp)) {
            $this->emp[] = $emp;
        }

        return $this;
    }

    public function removeEmp(historiqueEmplacement $emp): self
    {
        if ($this->emp->contains($emp)) {
            $this->emp->removeElement($emp);
        }

        return $this;
    }

    public function getEmplacement(): ?emplacement
    {
        return $this->emplacement;
    }

    public function setEmplacement(?emplacement $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function toString($machine): string
    {
        return '$this';
    }

    /**
     * @return Collection|HistoriqueEmplacement[]
     */
    public function getHistoriqueEmplacements(): Collection
    {
        return $this->historiqueEmplacements;
    }

    public function addHistoriqueEmplacement(HistoriqueEmplacement $historiqueEmplacement): self
    {
        if (!$this->historiqueEmplacements->contains($historiqueEmplacement)) {
            $this->historiqueEmplacements[] = $historiqueEmplacement;
            $historiqueEmplacement->setMachine($this);
        }

        return $this;
    }

    public function removeHistoriqueEmplacement(HistoriqueEmplacement $historiqueEmplacement): self
    {
        if ($this->historiqueEmplacements->contains($historiqueEmplacement)) {
            $this->historiqueEmplacements->removeElement($historiqueEmplacement);
            // set the owning side to null (unless already changed)
            if ($historiqueEmplacement->getMachine() === $this) {
                $historiqueEmplacement->setMachine(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DemandeIntervention[]
     */
    public function getDemandeInterventions(): Collection
    {
        return $this->demandeInterventions;
    }

    public function addDemandeIntervention(DemandeIntervention $demandeIntervention): self
    {
        if (!$this->demandeInterventions->contains($demandeIntervention)) {
            $this->demandeInterventions[] = $demandeIntervention;
            $demandeIntervention->setMachine($this);
        }

        return $this;
    }

    public function removeDemandeIntervention(DemandeIntervention $demandeIntervention): self
    {
        if ($this->demandeInterventions->contains($demandeIntervention)) {
            $this->demandeInterventions->removeElement($demandeIntervention);
            // set the owning side to null (unless already changed)
            if ($demandeIntervention->getMachine() === $this) {
                $demandeIntervention->setMachine(null);
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
            $preventive->setMachine($this);
        }

        return $this;
    }

    public function removePreventive(Preventive $preventive): self
    {
        if ($this->preventives->contains($preventive)) {
            $this->preventives->removeElement($preventive);
            // set the owning side to null (unless already changed)
            if ($preventive->getMachine() === $this) {
                $preventive->setMachine(null);
            }
        }

        return $this;
    }


}

