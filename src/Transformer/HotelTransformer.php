<?php

namespace App\Transformer;

use App\DTO\HotelDTO;
use App\Entity\Hotel;

class HotelTransformer {

    /**
     * Transformes a Hotel Object to HotelDTO object
     *
     * @param Hotel $hotel
     * @return HotelDTO
     */
    public static function transformHotelToHotelDTO(Hotel $hotel){
        if($hotel == null){
            return null;
        }
        $hotelDTO = (new HotelDTO)->setId($hotel->getId())
                                  ->setNom($hotel->getNom())
                                  ->setNumeroAdresse($hotel->getNumeroAdresse())
                                  ->setNomAdresse($hotel->getNomAdresse())
                                  ->setVille($hotel->getVille())
                                  ->setCodePostal($hotel->getCodePostal())
                                  ->setPays($hotel->getPays())
                                  ->setEmail($hotel->getEmail())
                                  ->setTelephone($hotel->getTelephone());

        return $hotelDTO;
    }

    public static function transformToListOfDTOS(array $hotels){
        $hotelsDTOs = [];
        foreach ($hotels as $h) {
            $hotelsDTOs[] = self::transformHotelToHotelDTO($h);
        }
        return $hotelsDTOs;
    }

    public static function transformToHotelEntity(HotelDTO $hotelDTO){
        if($hotelDTO == null){
            return null;
        }
        $hotel = (new Hotel) ->setNom($hotelDTO->getNom())
                             ->setNumeroAdresse($hotelDTO->getNumeroAdresse())
                             ->setNomAdresse($hotelDTO->getNomAdresse())
                             ->setVille($hotelDTO->getVille())
                             ->setCodePostal($hotelDTO->getCodePostal())
                             ->setPays($hotelDTO->getPays())
                             ->setEmail($hotelDTO->getEmail())
                             ->setTelephone($hotelDTO->getTelephone());

        return $hotel;
    }

    public static function updateNewHotelEntityByNewDTO(Hotel $old, HotelDTO $new){
        $old->setNom($new->getNom())
            ->setNumeroAdresse($new->getNumeroAdresse())
            ->setNomAdresse($new->getNomAdresse())
            ->setVille($new->getVille())
            ->setCodePostal($new->getCodePostal())
            ->setPays($new->getPays())
            ->setEmail($new->getEmail())
            ->setTelephone($new->getTelephone());

        return $old;
    }
}