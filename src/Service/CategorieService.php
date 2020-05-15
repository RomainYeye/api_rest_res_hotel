<?php

namespace App\Service;

use App\DTO\CategorieDTO;
use App\Repository\CategorieRepository;
use App\Transformer\CategorieTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Exception;

class CategorieService {

    private $categorieRepository;
    private $categorieEntityManager;

    public function __construct(EntityManagerInterface $manager, CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
        $this->categorieEntityManager = $manager;
    }

    public function findAllCategories(){
        $categories = $this->categorieRepository->findAll();
        $categorieDTOs = CategorieTransformer::transformToListOfDTOS($categories);
        return $categorieDTOs;
    }

    public function findAllCategoriesByHotel(int $idHotel){
        $categories = $this->categorieRepository->findAllCategoriesByHotel($idHotel);
        $categorieDTOs = CategorieTransformer::transformToListOfDTOS($categories);
        return $categorieDTOs;
    }

    public function addNewCategorie(CategorieDTO $categorieDTO){
        if($categorieDTO == null){
            throw new Exception("Contenu de la requête Post est vide.");
        }
        $categorie = CategorieTransformer::transformToCategorieEntity($categorieDTO);
        if ($categorie != null) {
            $this->categorieEntityManager->persist($categorie);
            $this->categorieEntityManager->flush();
        }
    }

    public function updateCategorie(int $id, CategorieDTO $categorieDTONew){
        $categorieOld = $this->categorieRepository->find($id);
        if($categorieOld == null){
            throw new Exception("Catégorie avec l'id $id non trouvée. Pas possible de la mettre à jour.");
        }
        $categorieNew = CategorieTransformer::updateNewCategorieEntityByNewDTO($categorieOld, $categorieDTONew);
        
        try {
            $this->categorieEntityManager->persist($categorieNew);
            $this->categorieEntityManager->flush();
        } catch (QueryException $e){
            throw $e;
        }

    }
}