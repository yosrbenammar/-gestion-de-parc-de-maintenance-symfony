<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SousTraitantRepository")
 */
class SousTraitant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected  $id;

    /**
     * @ORM\Column(type="string", length=20)
     *  * *@Assert\Length(min=3,max=255, minMessage="le nom est trop court");
     *  @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message=" nom invalide "
     * )
     */
    protected  $nom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected  $dateDebutContract;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *  * @Assert\GreaterThan(propertyPath="dateDebutContract" , message="la date de recrutement doit être superieur a date de naissance!")
     */
    protected  $dateFinContract;



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Preventive", mappedBy="sousTraitant")
     */
    private $preventives;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Curative", mappedBy="sousTraitant")
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateDebutContract(): ?\DateTimeInterface
    {
        return $this->dateDebutContract;
    }

    public function setDateDebutContract(?\DateTimeInterface $dateDebutContract): self
    {
        $this->dateDebutContract = $dateDebutContract;

        return $this;
    }

    public function getDateFinContract(): ?\DateTimeInterface
    {
        return $this->dateFinContract;
    }

    public function setDateFinContract(?\DateTimeInterface $dateFinContract): self
    {
        $this->dateFinContract = $dateFinContract;

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
            $preventive->setSousTraitant($this);
        }

        return $this;
    }

    public function removePreventive(Preventive $preventive): self
    {
        if ($this->preventives->contains($preventive)) {
            $this->preventives->removeElement($preventive);
            // set the owning side to null (unless already changed)
            if ($preventive->getSousTraitant() === $this) {
                $preventive->setSousTraitant(null);
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
            $curative->setSousTraitant($this);
        }

        return $this;
    }

    public function removeCurative(Curative $curative): self
    {
        if ($this->curatives->contains($curative)) {
            $this->curatives->removeElement($curative);
            // set the owning side to null (unless already changed)
            if ($curative->getSousTraitant() === $this) {
                $curative->setSousTraitant(null);
            }
        }

        return $this;
    }
}
