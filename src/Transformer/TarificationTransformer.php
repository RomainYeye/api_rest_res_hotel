<?php

namespace App\Transformer;

use App\DTO\TarificationDTO;
use App\Entity\Tarification;

class TarificationTransformer {

    /**
     * Transformes a Tarification Object to TarificationDTO object
     *
     * @param Tarification $tarification
     * @return TarificationDTO
     */
    public static function transformTarificationToTarificationDTO(Tarification $tarification){
        if($tarification == null){
            return null;
        }
        $tarificationDTO = (new TarificationDTO)->setTarif($tarification->getTarif())
                                                ->setHotelDTO(HotelTransformer::transformHotelToHotelDTO($tarification->getHotel()))
                                                ->setCategorieDTO(CategorieTransformer::transformCategorieToCategorieDTO($tarification->getCategorie()));
        return $tarificationDTO;
    }

    public static function transformToListOfDTOS(array $tarifications){
        $tarificationsDTOs = [];
        foreach ($tarifications as $t) {
            $tarificationsDTOs[] = self::transformTarificationToTarificationDTO($t);
        }
        return $tarificationsDTOs;
    }

    public static function transformToTarificationEntity(TarificationDTO $tarificationDTO){
        if($tarificationDTO == null){
            return null;
        }
        $tarification = (new Tarification)->setTarif($tarificationDTO->getTarif())
                                          ->setHotel(HotelTransformer::transformToHotelEntity($tarificationDTO->getHotelDTO()))
                                          ->setCategorie(CategorieTransformer::transformToCategorieEntity($tarificationDTO->getCategorieDTO()));
        return $tarification;
    }

    public static function updateNewTarificationEntityByNewDTO(Tarification $old, TarificationDTO $new){
        $old->setTarif($new->getTarif())
            ->setHotel(HotelTransformer::transformToHotelEntity($new->getHotelDTO()))
            ->setCategorie(CategorieTransformer::transformToCategorieEntity($new->getCategorieDTO()));

        return $old;
    }
}