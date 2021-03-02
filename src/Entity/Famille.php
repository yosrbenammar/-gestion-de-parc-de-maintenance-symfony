<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilleRepository")
 */
class Famille
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive( message="la dimension  doit etre supperieur a 0. !")
     */
    private $dimension;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SousFamille", mappedBy="fam")
     */
    private $sousfamille;

    public function __construct()
    {
        $this->sousfamille = new ArrayCollection();
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

    public function getDimension(): ?float
    {
        return $this->dimension;
    }

    public function setDimension(float $dimension): self
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * @return Collection|sousfamille[]
     */
    public function getSousfamille(): Collection
    {
        return $this->sousfamille;
    }

    public function addSousfamille(sousfamille $sousfamille): self
    {
        if (!$this->sousfamille->contains($sousfamille)) {
            $this->sousfamille[] = $sousfamille;
            $sousfamille->setFam($this);
        }

        return $this;
    }

    public function removeSousfamille(sousfamille $sousfamille): self
    {
        if ($this->sousfamille->contains($sousfamille)) {
            $this->sousfamille->removeElement($sousfamille);
            // set the owning side to null (unless already changed)
            if ($sousfamille->getFam() === $this) {
                $sousfamille->setFam(null);
            }
        }

        return $this;
    }

}
