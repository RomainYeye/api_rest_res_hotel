<?php

namespace App\Controller\Rest;

use App\DTO\ClientDTO;
use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Service\ClientService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ClientRestController extends AbstractFOSRestController {

    private $clientService;
    private $clientEntityManager;
    private $clientRepository;

    const ALL_CLIENTS_URI = "/clients";
    const SINGLE_CLIENT_URI = "/clients/{id}"; 

    public function __construct(ClientService $clientService, EntityManagerInterface $manager, ClientRepository $clientRepository)
    {
        $this->clientService = $clientService;
        $this->clientEntityManager = $manager;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Look for all clients in database
     * @Get(ClientRestController::ALL_CLIENTS_URI)
     * @param ClientRepository $clientRepository
     * @return Response
     */
    public function findAllClients(){
        $clients = $this->clientService->findAllClients();
        if(empty($clients)){
            return View::create(null, Response::HTTP_NO_CONTENT);
        }
        return View::create($clients, Response::HTTP_OK);
    }

    /**
     * Create a new client in database
     * @POST(ClientRestController::ALL_CLIENTS_URI)
     * @ParamConverter("clientDTO", converter="fos_rest.request_body")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function createClient(ClientDTO $clientDTO){
        try{
            $this->clientService->addNewClient($clientDTO);
        } catch (Exception $e){
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_CREATED);
    }

    /**
     * Modifies a client in database
     * @Put(ClientRestController::SINGLE_CLIENT_URI)
     * @ParamConverter("clientDTO", converter="fos_rest.request_body")
     * @param Request $request
     * @param Client $client
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function updateClient(ClientDTO $clientDTO, int $id){
        try {
            $this->clientService->updateClient($id, $clientDTO);
        } catch (QueryException $qe){
            return View::create("Echec lors de la mise à jour pour le client avec l'id $id", Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e){
            return View::create($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}