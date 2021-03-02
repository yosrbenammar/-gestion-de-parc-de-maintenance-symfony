<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntreeRepository")
 */
class Entree
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     *  * @Assert\Positive( message="la quantité doit etre supperieur a 0. !")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PieceRechange", inversedBy="entrees" )
     * @ORM\JoinColumn(nullable=false)
     */
    private $pieceRechange;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $source;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fournisseur", inversedBy="entrees")
     */
    private $fournisseur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FicheDemontage", mappedBy="piece")
     */
    private $ficheDemontages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FicheDemontage", inversedBy="entrees")
     */
    private $demontage;



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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPieceRechange(): ?pieceRechange
    {
        return $this->pieceRechange;
    }

    public function setPieceRechange(?pieceRechange $pieceRechange): self
    {
        $this->pieceRechange = $pieceRechange;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getFournisseur(): ?fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }



    public function getDemontage(): ?FicheDemontage
    {
        return $this->demontage;
    }

    public function setDemontage(?FicheDemontage $demontage): self
    {
        $this->demontage = $demontage;

        return $this;
    }

    public function getFicheDemontage(): ?FicheDemontage
    {
        return $this->ficheDemontage;
    }

    public function setFicheDemontage(?FicheDemontage $ficheDemontage): self
    {
        $this->ficheDemontage = $ficheDemontage;

        return $this;
    }
}
