<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
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
    private $nbPersonnes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $litSimple;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $litDouble;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $litKing;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chambre", mappedBy="categorie")
     */
    private $chambres;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tarification", mappedBy="categorie")
     */
    private $tarifications;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbPersonnes(): ?int
    {
        return $this->nbPersonnes;
    }

    public function setNbPersonnes(int $nbPersonnes): self
    {
        $this->nbPersonnes = $nbPersonnes;

        return $this;
    }

    public function getLitSimple(): ?int
    {
        return $this->litSimple;
    }

    public function setLitSimple(?int $litSimple): self
    {
        $this->litSimple = $litSimple;

        return $this;
    }

    public function getLitDouble(): ?int
    {
        return $this->litDouble;
    }

    public function setLitDouble(?int $litDouble): self
    {
        $this->litDouble = $litDouble;

        return $this;
    }

    public function getLitKing(): ?int
    {
        return $this->litKing;
    }

    public function setLitKing(?int $litKing): self
    {
        $this->litKing = $litKing;

        return $this;
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

}
