<?php

namespace App\Service;

use App\DTO\ChambreDTO;
use App\Repository\ChambreRepository;
use App\Transformer\ChambreTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Exception;

class ChambreService {

    private $chambreRepository;
    private $chambreEntityManager;

    public function __construct(EntityManagerInterface $manager, ChambreRepository $chambreRepository)
    {
        $this->chambreRepository = $chambreRepository;
        $this->chambreEntityManager = $manager;
    }

    public function findAllChambres(){
        $chambres = $this->chambreRepository->findAll();
        $chambreDTOs = ChambreTransformer::transformToListOfDTOS($chambres);
        return $chambreDTOs;
    }

    public function findAllChambresByHotel(int $idHotel){
        $chambres = $this->chambreRepository->findBy(["hotel" => $idHotel]);
        $chambreDTOs = ChambreTransformer::transformToListOfDTOS($chambres);
        return $chambreDTOs;
    }

    public function addNewChambre(ChambreDTO $chambreDTO){
        if($chambreDTO == null){
            throw new Exception("Contenu de la requête Post est vide.");
        }
        $chambre = ChambreTransformer::transformToChambreEntity($chambreDTO);
        if ($chambre != null) {
            $this->chambreEntityManager->persist($chambre);
            $this->chambreEntityManager->flush();
        }
    }

    public function updateChambre(int $id, ChambreDTO $chambreDTONew){
        $chambreOld = $this->chambreRepository->find($id);
        if($chambreOld == null){
            throw new Exception("Chambre avec l'id $id non trouvée. Pas possible de la mettre à jour.");
        }
        $chambreNew = ChambreTransformer::updateNewChambreEntityByNewDTO($chambreOld, $chambreDTONew);
        
        try {
            $this->chambreEntityManager->persist($chambreNew);
            $this->chambreEntityManager->flush();
        } catch (QueryException $e){
            throw $e;
        }

    }
}