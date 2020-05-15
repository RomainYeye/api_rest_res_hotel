<?php

namespace App\Transformer;

use App\DTO\CategorieDTO;
use App\Entity\Categorie;

class CategorieTransformer {

    /**
     * Transformes a Categorie Object to CategorieDTO object
     *
     * @param Categorie $categorie
     * @return CategorieDTO
     */
    public static function transformCategorieToCategorieDTO(Categorie $categorie){
        if($categorie == null){
            return null;
        }
        $categorieDTO = (new CategorieDTO)->setNbPersonnes($categorie->getNbPersonnes())
                                          ->setLitSimple($categorie->getLitSimple())
                                          ->setLitDouble($categorie->getLitDouble())
                                          ->setLitKing($categorie->getLitKing())
                                          ->setNom($categorie->getNom());

        return $categorieDTO;
    }

    public static function transformToListOfDTOS(array $categories){
        $categoriesDTOs = [];
        foreach ($categories as $c) {
            $categoriesDTOs[] = self::transformCategorieToCategorieDTO($c);
        }
        return $categoriesDTOs;
    }

    public static function transformToCategorieEntity(CategorieDTO $categorieDTO){
        if($categorieDTO == null){
            return null;
        }
        $categorie = (new Categorie)->setNbPersonnes($categorieDTO->getNbPersonnes())
                                    ->setLitSimple($categorieDTO->getLitSimple())
                                    ->setLitDouble($categorieDTO->getLitDouble())
                                    ->setLitKing($categorieDTO->getLitKing())
                                    ->setNom($categorieDTO->getNom());

        return $categorie;
    }

    public static function updateNewCategorieEntityByNewDTO(Categorie $old, CategorieDTO $new){
        $old->setNbPersonnes($new->getNbPersonnes())
            ->setLitSimple($new->getLitSimple())
            ->setLitDouble($new->getLitDouble())
            ->setLitKing($new->getLitKing())
            ->setNom($new->getNom());

        return $old;
    }
}