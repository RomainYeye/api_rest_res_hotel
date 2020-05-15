<?php

namespace App\Controller\Rest;

use App\DTO\TarificationDTO;
use App\Entity\Tarification;
use App\Repository\TarificationRepository;
use App\Service\TarificationService;
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


class TarificationRestController extends AbstractFOSRestController {

    private $tarificationService;
    private $tarificationEntityManager;
    private $tarificationRepository;

    const ALL_TARIFICATIONS_URI = "/tarifications";
    const SINGLE_TARIFICATION_URI = "/tarifications/{id}"; 

    public function __construct(TarificationService $tarificationService, EntityManagerInterface $manager, TarificationRepository $tarificationRepository)
    {
        $this->tarificationService = $tarificationService;
        $this->tarificationEntityManager = $manager;
        $this->tarificationRepository = $tarificationRepository;
    }

    /**
     * Look for all tarifications in database
     * @Get(TarificationRestController::ALL_TARIFICATIONS_URI)
     * @param TarificationRepository $tarificationRepository
     * @return Response
     */
    public function findAllTarifications(){
        $tarifications = $this->tarificationService->findAllTarifications();
        if(empty($tarifications)){
            return View::create(null, Response::HTTP_NO_CONTENT);
        }
        return View::create($tarifications, Response::HTTP_OK);
    }

    /**
     * Create a new tarification in database
     * @POST(TarificationRestController::ALL_TARIFICATIONS_URI)
     * @ParamConverter("tarificationDTO", converter="fos_rest.request_body")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function createTarification(TarificationDTO $tarificationDTO){
        try{
            $this->tarificationService->addNewTarification($tarificationDTO);
        } catch (Exception $e){
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_CREATED);
    }

    /**
     * Modifies a tarification in database
     * @Put(TarificationRestController::SINGLE_TARIFICATION_URI)
     * @ParamConverter("tarificationDTO", converter="fos_rest.request_body")
     * @param Request $request
     * @param Tarification $tarification
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function updateTarification(TarificationDTO $tarificationDTO, int $id){
        try {
            $this->tarificationService->updateTarification($id, $tarificationDTO);
        } catch (QueryException $qe){
            return View::create("Echec lors de la mise à jour pour la tarification", Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e){
            return View::create($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}