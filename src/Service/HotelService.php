<?php

namespace App\Service;

use App\DTO\HotelDTO;
use App\Repository\HotelRepository;
use App\Transformer\CategorieTransformer;
use App\Transformer\HotelTransformer;
use App\Transformer\ChambreTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Exception;

class HotelService {

    private $hotelRepository;
    private $hotelEntityManager;

    public function __construct(EntityManagerInterface $manager, HotelRepository $hotelRepository)
    {
        $this->hotelRepository = $hotelRepository;
        $this->hotelEntityManager = $manager;
    }

    public function findOneSpecificHotel(int $id) {
        $hotel = $this->hotelRepository->find($id);
        $hotelDTO = HotelTransformer::transformHotelToHotelDTO($hotel);
        return $hotelDTO;
    }

    public function findAllHotels(){
        $hotels = $this->hotelRepository->findAll();
        $hotelDTOs = HotelTransformer::transformToListOfDTOS($hotels);
        return $hotelDTOs;
    }

    public function findAllHotelsByPays(string $pays){
        $hotels = $this->hotelRepository->findBy(["pays" => $pays]);
        $hotelDTOs = HotelTransformer::transformToListOfDTOS($hotels);
        return $hotelDTOs;
    }

    public function findAllHotelsByVille(string $ville){
        $hotels = $this->hotelRepository->findBy(["ville" => $ville]);
        $hotelDTOs = HotelTransformer::transformToListOfDTOS($hotels);
        return $hotelDTOs;
    }

    public function findAllCategoriesByHotel(int $idHotel){
        $categories = $this->hotelRepository->findAllCategoriesByHotel($idHotel);
        $categorieDTOs = CategorieTransformer::transformToListOfDTOS($categories);
        return $categorieDTOs;
    }

    public function findAllChambresAvailableByDates(int $idHotel, int $idCategorie, string $dateDebut, string $dateFin){
        $chambres = $this->hotelRepository->findAllChambresAvailableByDates($idHotel, $idCategorie, $dateDebut, $dateFin);
        $chambreDTOs = ChambreTransformer::transformToListOfDTOS($chambres);
        return $chambreDTOs;
    }

    public function addNewHotel(HotelDTO $hotelDTO){
        if($hotelDTO == null){
            throw new Exception("Contenu de la requête Post est vide.");
        }
        $hotel = HotelTransformer::transformToHotelEntity($hotelDTO);
        if ($hotel != null) {
            $this->hotelEntityManager->persist($hotel);
            $this->hotelEntityManager->flush();
        }
    }

    public function updateHotel(int $id, HotelDTO $hotelDTONew){
        $hotelOld = $this->hotelRepository->find($id);
        if($hotelOld == null){
            throw new Exception("Hôtel avec l'id $id non trouvé. Pas possible de le mettre à jour.");
        }
        $hotelNew = HotelTransformer::updateNewHotelEntityByNewDTO($hotelOld, $hotelDTONew);
        
        try {
            $this->hotelEntityManager->persist($hotelNew);
            $this->hotelEntityManager->flush();
        } catch (QueryException $e){
            throw $e;
        }

    }
}