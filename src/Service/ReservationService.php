<?php

namespace App\Service;

use App\DTO\ReservationDTO;
use App\Repository\ReservationRepository;
use App\Transformer\ReservationTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Exception;

class ReservationService {

    private $reservationRepository;
    private $reservationEntityManager;

    public function __construct(EntityManagerInterface $manager, ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->reservationEntityManager = $manager;
    }

    public function findAllReservations(){
        $reservations = $this->reservationRepository->findAll();
        $reservationDTOs = ReservationTransformer::transformToListOfDTOS($reservations);
        return $reservationDTOs;
    }

    public function addNewReservation(ReservationDTO $reservationDTO){
        if($reservationDTO == null){
            throw new Exception("Contenu de la requête Post est vide.");
        }
        $reservation = ReservationTransformer::transformToReservationEntity($reservationDTO);
        if ($reservation != null) {
            $this->reservationEntityManager->persist($reservation);
            $this->reservationEntityManager->flush();
        }
    }

    public function updateReservation(int $id, ReservationDTO $reservationDTONew){
        $reservationOld = $this->reservationRepository->find($id);
        if($reservationOld == null){
            throw new Exception("Réservation avec l'id $id non trouvée. Pas possible de la mettre à jour.");
        }
        $reservationNew = ReservationTransformer::updateNewReservationEntityByNewDTO($reservationOld, $reservationDTONew);
        
        try {
            $this->reservationEntityManager->persist($reservationNew);
            $this->reservationEntityManager->flush();
        } catch (QueryException $e){
            throw $e;
        }

    }
}