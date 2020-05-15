<?php

namespace App\DTO;

/**
 * Un objet DTO (Data Transfer Object)
 */

class ReservationDTO
{
    private $dateDebut;
    private $dateFin;
    private $nbNuitees;
    private $prixTotal;
    private $clientDTO;
    private $chambreDTO;

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

    public function getNbNuitees(): ?int
    {
        return $this->nbNuitees;
    }

    public function setNbNuitees(int $nbNuitees): self
    {
        $this->nbNuitees = $nbNuitees;

        return $this;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(float $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getClientDTO(): ?ClientDTO
    {
        return $this->clientDTO;
    }

    public function setClientDTO(?ClientDTO $clientDTO): self
    {
        $this->clientDTO = $clientDTO;

        return $this;
    }

    public function getChambreDTO(): ?ChambreDTO
    {
        return $this->chambreDTO;
    }

    public function setChambreDTO(?ChambreDTO $chambreDTO): self
    {
        $this->chambreDTO = $chambreDTO;

        return $this;
    }
}
