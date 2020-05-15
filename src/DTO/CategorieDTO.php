<?php

namespace App\DTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Un objet DTO (Data Transfer Object)
 */

class CategorieDTO
{
    private $nbPersonnes;
    private $litSimple;
    private $litDouble;
    private $litKing;
    private $nom;
    private $chambresDTO;
    private $tarificationsDTO;

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
