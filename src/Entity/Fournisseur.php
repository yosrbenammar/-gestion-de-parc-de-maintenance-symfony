<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\FournisseurRepository")
 **@UniqueEntity("tel",message="Il existe déjà un fournisseur ayant ce numéro!!")
 */
class Fournisseur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     *  *  @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message=" nom invalide "
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", unique=true, length=20)
     * @Assert\Regex(pattern="/^[0-9]*$/" , message="numéro invalide!ce champs doit contenir que des chiffre  ")
     * @Assert\Length(
     *      min = 8,
     *       minMessage = "le numéro doit est composées exactement de 8 chiffres",
     *      max = 8,
     *      maxMessage = "le numéro doit est composées exactement de 8 chiffres",
     *      allowEmptyString = false
     * )
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $adress;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entree", mappedBy="Fournisseur")
     */
    private $entrees;

    public function __construct()
    {
        $this->entrees = new ArrayCollection();
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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * @return Collection|Entree[]
     */
    public function getEntrees(): Collection
    {
        return $this->entrees;
    }

    public function addEntree(Entree $entree): self
    {
        if (!$this->entrees->contains($entree)) {
            $this->entrees[] = $entree;
            $entree->setFournisseur($this);
        }

        return $this;
    }

    public function removeEntree(Entree $entree): self
    {
        if ($this->entrees->contains($entree)) {
            $this->entrees->removeElement($entree);
            // set the owning side to null (unless already changed)
            if ($entree->getFournisseur() === $this) {
                $entree->setFournisseur(null);
            }
        }

        return $this;
    }
}
