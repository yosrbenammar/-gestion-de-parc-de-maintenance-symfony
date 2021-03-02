<?php

namespace App\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\FormTypeInterface;

trait  EmployeTrait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;




    /**
     * @ORM\Column(type="string", length=255)
     * *@Assert\Length(min=3,max=255, minMessage="le nom est trop court");
     *  @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message=" nom invalide "
     * )
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * *@Assert\Length(min=3,max=255, minMessage="le prénom est trop court");
     *    @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message=" prénom  invlide"
     )
     */
    protected $prenom;


    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    protected $adresse;

    /**
     * @ORM\Column(type="string", unique=true,length=8)
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "le numéro doit est composées exactement de 8 chiffres",
     *      maxMessage = "le numéro doit est composées exactement de 8 chiffres",
     *      allowEmptyString = false
     * )
     */

    protected $tel;

    /**
     * @ORM\Column(type="datetime")
     *@Assert\LessThan("today" , message="la date de naissance doit être inférieur a date d'aujoud'hui!")
     */
    protected $date_naissance;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan(propertyPath="date_naissance" , message="la date de recrutement doit être superieur a date de naissance!")
     * @Assert\LessThan("today" ,message="la date de recrutement doit être inférieur a date d'aujoud'hui!")
     *
     */
    protected $date_recrutement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DemandeIntervention", mappedBy="proclmateur")
     */
    private $demandeInterventions;

    public function __construct()
    {
        $this->demandeInterventions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getDateRecrutement(): ?\DateTimeInterface
    {
        return $this->date_recrutement;
    }

    public function setDateRecrutement(\DateTimeInterface $date_recrutement): self
    {
        $this->date_recrutement = $date_recrutement;

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
            $demandeIntervention->setProclmateur($this);
        }

        return $this;
    }

    public function removeDemandeIntervention(DemandeIntervention $demandeIntervention): self
    {
        if ($this->demandeInterventions->contains($demandeIntervention)) {
            $this->demandeInterventions->removeElement($demandeIntervention);
            // set the owning side to null (unless already changed)
            if ($demandeIntervention->getProclmateur() === $this) {
                $demandeIntervention->setProclmateur(null);
            }
        }

        return $this;
    }
}
