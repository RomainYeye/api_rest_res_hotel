<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TarificationRepository")
 */
class Tarification
{

    /**
     * @ORM\Column(type="float")
     */
    private $tarif;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Hotel", inversedBy="tarifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hotel;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="tarifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
