<?php

namespace App\Entity\Traits;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

Trait InterventionTrait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(min=3,max=15, minMessage="le titre est trop court");
     *  @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message=" titre invalide ");
     */
    protected $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3 , minMessage="la description est trés courte");

     */
    protected $desription;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $etat;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    protected $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     *  @Assert\GreaterThan("today" , message="la date fin doit être superieur a date de debut !")
     */
    protected $dateFin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDesription(): ?string
    {
        return $this->desription;
    }

    public function setDesription(string $desription): self
    {
        $this->desription = $desription;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

}
