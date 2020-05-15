<?php

namespace App\Transformer;

use App\DTO\ReservationDTO;
use App\Entity\Reservation;

class ReservationTransformer {

    /**
     * Transformes a Reservation Object to ReservationDTO object
     *
     * @param Reservation $reservation
     * @return ReservationDTO
     */
    public static function transformReservationToReservationDTO(Reservation $reservation){
        if($reservation == null){
            return null;
        }
        $reservationDTO = (new ReservationDTO)->setDateDebut($reservation->getDateDebut())
                                              ->setDateFin($reservation->getDateFin())
                                              ->setNbNuitees($reservation->getNbNuitees())
                                              ->setPrixTotal($reservation->getPrixTotal())
                                              ->setClientDTO(ClientTransformer::transformClientToClientDTO($reservation->getClient()))
                                              ->setChambreDTO(ChambreTransformer::transformChambreToChambreDTO($reservation->getChambre()));
        return $reservationDTO;
    }

    public static function transformToListOfDTOS(array $reservations){
        $reservationsDTOs = [];
        foreach ($reservations as $r) {
            $reservationsDTOs[] = self::transformReservationToReservationDTO($r);
        }
        return $reservationsDTOs;
    }

    public static function transformToReservationEntity(ReservationDTO $reservationDTO){
        if($reservationDTO == null){
            return null;
        }
        $reservation = (new Reservation) ->setDateDebut($reservationDTO->getDateDebut())
                                         ->setDateFin($reservationDTO->getDateFin())
                                         ->setNbNuitees($reservationDTO->getNbNuitees())
                                         ->setPrixTotal($reservationDTO->getPrixTotal())
                                         ->setClient(ClientTransformer::transformToClientEntity($reservationDTO->getClientDTO()))
                                         ->setChambre(ChambreTransformer::transformToChambreEntity($reservationDTO->getChambreDTO()));
        return $reservation;
    }

    public static function updateNewReservationEntityByNewDTO(Reservation $old, ReservationDTO $new){
        $old->setDateDebut($new->getDateDebut())
            ->setDateFin($new->getDateFin())
            ->setNbNuitees($new->getNbNuitees())
            ->setPrixTotal($new->getPrixTotal())
            ->setClient(ClientTransformer::transformToClientEntity($new->getClientDTO()))
            ->setChambre(ChambreTransformer::transformToChambreEntity($new->getChambreDTO()));

        return $old;
    }
}