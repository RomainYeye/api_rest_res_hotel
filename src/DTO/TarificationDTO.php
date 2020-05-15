<?php

namespace App\DTO;

/**
 * Un objet DTO (Data Transfer Object)
 */

class TarificationDTO
{
    private $tarif;
    private $hotelDTO;
    private $categorieDTO;

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): self
    {
        $this->tarif = $tarif;

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
