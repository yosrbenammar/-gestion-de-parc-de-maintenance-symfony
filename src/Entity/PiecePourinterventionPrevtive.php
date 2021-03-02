<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PiecePourinterventionPrevtiveRepository")
 */
class PiecePourinterventionPrevtive
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PieceRechange", inversedBy="piecePourinterventionPrevtives")
     */
    private $piece;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Preventive", inversedBy="piecePourinterventionPrevtives")
     */
    private $intervention;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPiece(): ?PieceRechange
    {
        return $this->piece;
    }

    public function setPiece(?PieceRechange $piece): self
    {
        $this->piece = $piece;

        return $this;
    }

    public function getIntervention(): ?Preventive
    {
        return $this->intervention;
    }

    public function setIntervention(?Preventive $intervention): self
    {
        $this->intervention = $intervention;

        return $this;
    }
}
