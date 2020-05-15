<?php

namespace App\Service;

use App\DTO\ClientDTO;
use App\Repository\ClientRepository;
use App\Transformer\ClientTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Exception;

class ClientService {

    private $clientRepository;
    private $clientEntityManager;

    public function __construct(EntityManagerInterface $manager, ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->clientEntityManager = $manager;
    }

    public function findAllClients(){
        $clients = $this->clientRepository->findAll();
        $clientDTOs = ClientTransformer::transformToListOfDTOS($clients);
        return $clientDTOs;
    }

    public function addNewClient(ClientDTO $clientDTO){
        if($clientDTO == null){
            throw new Exception("Contenu de la requête Post est vide.");
        }
        $client = ClientTransformer::transformToClientEntity($clientDTO);
        if ($client != null) {
            $this->clientEntityManager->persist($client);
            $this->clientEntityManager->flush();
        }
    }

    public function updateClient(int $id, ClientDTO $clientDTONew){
        $clientOld = $this->clientRepository->find($id);
        if($clientOld == null){
            throw new Exception("Client avec l'id $id non trouvé. Pas possible de le mettre à jour.");
        }
        $clientNew = ClientTransformer::updateNewClientEntityByNewDTO($clientOld, $clientDTONew);
        
        try {
            $this->clientEntityManager->persist($clientNew);
            $this->clientEntityManager->flush();
        } catch (QueryException $e){
            throw $e;
        }

    }
}