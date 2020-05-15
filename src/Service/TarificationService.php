<?php

namespace App\Service;

use App\DTO\TarificationDTO;
use App\Repository\TarificationRepository;
use App\Transformer\TarificationTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Exception;

class TarificationService {

    private $tarificationRepository;
    private $tarificationEntityManager;

    public function __construct(EntityManagerInterface $manager, TarificationRepository $tarificationRepository)
    {
        $this->tarificationRepository = $tarificationRepository;
        $this->tarificationEntityManager = $manager;
    }

    public function findAllTarifications(){
        $tarifications = $this->tarificationRepository->findAll();
        $tarificationDTOs = TarificationTransformer::transformToListOfDTOS($tarifications);
        return $tarificationDTOs;
    }

    public function addNewTarification(TarificationDTO $tarificationDTO){
        if($tarificationDTO == null){
            throw new Exception("Contenu de la requête Post est vide.");
        }
        $tarification = TarificationTransformer::transformToTarificationEntity($tarificationDTO);
        if ($tarification != null) {
            $this->tarificationEntityManager->persist($tarification);
            $this->tarificationEntityManager->flush();
        }
    }

    public function updateTarification(int $id, TarificationDTO $tarificationDTONew){
        $tarificationOld = $this->tarificationRepository->find($id);
        if($tarificationOld == null){
            throw new Exception("Hôtel avec l'id $id non trouvé. Pas possible de le mettre à jour.");
        }
        $tarificationNew = TarificationTransformer::updateNewTarificationEntityByNewDTO($tarificationOld, $tarificationDTONew);
        
        try {
            $this->tarificationEntityManager->persist($tarificationNew);
            $this->tarificationEntityManager->flush();
        } catch (QueryException $e){
            throw $e;
        }

    }
}