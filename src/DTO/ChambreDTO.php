<?php

namespace App\DTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Un objet DTO (Data Transfer Object)
 */

class ChambreDTO
{
    private $numeroChambre;
    private $reservationsDTO;
    private $hotelDTO;
    private $categorieDTO;

    public function __construct()
    {
        $this->reservationsDTO = new ArrayCollection();
    }

    public function getNumeroChambre(): ?int
    {
        return $this->numeroChambre;
    }

    public function setNumeroChambre(int $numeroChambre): self
    {
        $this->numeroChambre = $numeroChambre;

        return $this;
    }

    public function getHotelDTO(): ?HotelDTO
    {
        return $this->hotelDTO;
    }

    public function setHotelDTO(?HotelDTO $hotelDTO): self
    {
        $this->hotelDTO = $hotelDTO;

        return $this;
    }

    public function getCategorieDTO(): ?CategorieDTO
    {
        return $this->categorieDTO;
    }

    public function setCategorieDTO(?CategorieDTO $categorieDTO): self
    {
        $this->categorieDTO = $categorieDTO;

        return $this;
    }
}
