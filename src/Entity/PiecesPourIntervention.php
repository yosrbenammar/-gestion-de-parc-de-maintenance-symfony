<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PiecesPourInterventionRepository")
 */
class PiecesPourIntervention
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
     * @ORM\ManyToOne(targetEntity="App\Entity\PieceRechange")
     * @ORM\JoinColumn(nullable=false)
     */
    private $piece;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Curative", cascade={"persist"}, inversedBy="piecePourIntervention")

     * @ORM\JoinColumn(nullable=false)
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

    public function getIntervention(): ?Curative
    {
        return $this->intervention;
    }

    public function setIntervention(?Curative $intervention): self
    {
        $this->intervention = $intervention;

        return $this;
    }

    public function getPiecePourIntervention(): ?Curative
    {
        return $this->piecePourIntervention;
    }

    public function setPiecePourIntervention(?Curative $piecePourIntervention): self
    {
        $this-> piecePourIntervention = $piecePourIntervention;

        return $this;
    }





}
