<?php

namespace App\Transformer;

use App\DTO\ChambreDTO;
use App\Entity\Chambre;

class ChambreTransformer {

    /**
     * Transformes a Chambre Object to ChambreDTO object
     *
     * @param Chambre $chambre
     * @return ChambreDTO
     */
    public static function transformChambreToChambreDTO(Chambre $chambre){
        if($chambre == null){
            return null;
        }
        $chambreDTO = (new ChambreDTO)->setNumeroChambre($chambre->getNumeroChambre())
                                      ->setHotelDTO(HotelTransformer::transformHotelToHotelDTO($chambre->getHotel()))
                                      ->setCategorieDTO(CategorieTransformer::transformCategorieToCategorieDTO($chambre->getCategorie()));

        return $chambreDTO;
    }

    public static function transformToListOfDTOS(array $chambres){
        $chambresDTOs = [];
        foreach ($chambres as $c) {
            $chambresDTOs[] = self::transformChambreToChambreDTO($c);
        }
        return $chambresDTOs;
    }

    public static function transformToChambreEntity(ChambreDTO $chambreDTO){
        if($chambreDTO == null){
            return null;
        }
        $chambre = (new Chambre)->setNumeroChambre($chambreDTO->getNumeroChambre())
                                ->setHotel(HotelTransformer::transformToHotelEntity($chambreDTO->getHotelDTO()))
                                ->setCategorie(CategorieTransformer::transformToCategorieEntity($chambreDTO->getCategorieDTO()));

        return $chambre;
    }

    public static function updateNewChambreEntityByNewDTO(Chambre $old, ChambreDTO $new){
        $old->setNumeroChambre($new->getNumeroChambre())
            ->setHotel(HotelTransformer::transformToHotelEntity($new->getHotelDTO()))
            ->setCategorie(CategorieTransformer::transformToCategorieEntity($new->getCategorieDTO()));

        return $old;
    }
}