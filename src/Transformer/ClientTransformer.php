<?php

namespace App\Transformer;

use App\DTO\ClientDTO;
use App\Entity\Client;

class ClientTransformer {

    /**
     * Transformes a Client Object to ClientDTO object
     *
     * @param Client $client
     * @return ClientDTO
     */
    public static function transformClientToClientDTO(Client $client){
        if($client == null){
            return null;
        }
        $clientDTO = (new ClientDTO)->setPrenom($client->getPrenom())
                                    ->setNom($client->getNom())
                                    ->setEmail($client->getEmail())
                                    ->setTelephone($client->getTelephone())
                                    ->setNumeroAdresse($client->getNumeroAdresse())
                                    ->setNomAdresse($client->getNomAdresse())
                                    ->setVille($client->getVille())
                                    ->setCodePostal($client->getCodePostal())
                                    ->setPays($client->getPays());

        return $clientDTO;
    }

    public static function transformToListOfDTOS(array $clients){
        $clientsDTOs = [];
        foreach ($clients as $c) {
            $clientsDTOs[] = self::transformClientToClientDTO($c);
        }
        return $clientsDTOs;
    }

    public static function transformToClientEntity(ClientDTO $clientDTO){
        if($clientDTO == null){
            return null;
        }
        $client = (new Client) ->setPrenom($clientDTO->getPrenom())
                               ->setNom($clientDTO->getNom())
                               ->setEmail($clientDTO->getEmail())
                               ->setTelephone($clientDTO->getTelephone())
                               ->setNumeroAdresse($clientDTO->getNumeroAdresse())
                               ->setNomAdresse($clientDTO->getNomAdresse())
                               ->setVille($clientDTO->getVille())
                               ->setCodePostal($clientDTO->getCodePostal())
                               ->setPays($clientDTO->getPays());

        return $client;
    }

    public static function updateNewClientEntityByNewDTO(Client $old, ClientDTO $new){
        $old->setPrenom($new->getPrenom())
            ->setNom($new->getNom())
            ->setEmail($new->getEmail())
            ->setTelephone($new->getTelephone())
            ->setNumeroAdresse($new->getNumeroAdresse())
            ->setNomAdresse($new->getNomAdresse())
            ->setVille($new->getVille())
            ->setCodePostal($new->getCodePostal())
            ->setPays($new->getPays());

        return $old;
    }
}