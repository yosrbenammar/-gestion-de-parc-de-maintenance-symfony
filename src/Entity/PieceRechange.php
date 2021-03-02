<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table
 * @ORM\Entity */

class PieceRechange
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected  $id;

    /**
     * @ORM\Column(type="string", length=90)
     */
    protected  $designation;

    /**
     * @ORM\Column(type="integer")
     *
     */
    protected  $quantite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entree", mappedBy="pieceRechange")
     */
    protected  $entrees;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Curative", mappedBy="piece")
     */
    private $curatives;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Preventive", mappedBy="piece")
     */
    private $preventives;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PiecesPourIntervention", mappedBy="pieceRechange")
     */
    private $piecePourIntervention;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PiecePourinterventionPrevtive", mappedBy="piece")
     */
    private $piecePourinterventionPrevtives;


    public function __construct()
    {
        $this->entrees = new ArrayCollection();
        $this->curatives = new ArrayCollection();
        $this->preventives = new ArrayCollection();
        $this->piecePourIntervention = new ArrayCollection();
        $this->piecePourinterventionPrevtives = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

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
            $entree->setPieceRechange($this);
        }

        return $this;
    }

    public function removeEntree(Entree $entree): self
    {
        if ($this->entrees->contains($entree)) {
            $this->entrees->removeElement($entree);
            // set the owning side to null (unless already changed)
            if ($entree->getPieceRechange() === $this) {
                $entree->setPieceRechange(null);
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
            $curative->addPiece($this);
        }

        return $this;
    }

    public function removeCurative(Curative $curative): self
    {
        if ($this->curatives->contains($curative)) {
            $this->curatives->removeElement($curative);
            $curative->removePiece($this);
        }

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
            $piecePourIntervention->setPieceRechange($this);
        }

        return $this;
    }

    public function removePiecePourIntervention(PiecesPourIntervention $piecePourIntervention): self
    {
        if ($this->piecePourIntervention->contains($piecePourIntervention)) {
            $this->piecePourIntervention->removeElement($piecePourIntervention);
            // set the owning side to null (unless already changed)
            if ($piecePourIntervention->getPieceRechange() === $this) {
                $piecePourIntervention->setPieceRechange(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PiecePourinterventionPrevtive[]
     */
    public function getPiecePourinterventionPrevtives(): Collection
    {
        return $this->piecePourinterventionPrevtives;
    }

    public function addPiecePourinterventionPrevtive(PiecePourinterventionPrevtive $piecePourinterventionPrevtive): self
    {
        if (!$this->piecePourinterventionPrevtives->contains($piecePourinterventionPrevtive)) {
            $this->piecePourinterventionPrevtives[] = $piecePourinterventionPrevtive;
            $piecePourinterventionPrevtive->setPiece($this);
        }

        return $this;
    }

    public function removePiecePourinterventionPrevtive(PiecePourinterventionPrevtive $piecePourinterventionPrevtive): self
    {
        if ($this->piecePourinterventionPrevtives->contains($piecePourinterventionPrevtive)) {
            $this->piecePourinterventionPrevtives->removeElement($piecePourinterventionPrevtive);
            // set the owning side to null (unless already changed)
            if ($piecePourinterventionPrevtive->getPiece() === $this) {
                $piecePourinterventionPrevtive->setPiece(null);
            }
        }

        return $this;
    }


}
