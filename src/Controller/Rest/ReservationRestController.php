<?php

namespace App\Controller\Rest;

use App\DTO\ReservationDTO;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Service\ReservationService;
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


class ReservationRestController extends AbstractFOSRestController {

    private $reservationService;
    private $reservationEntityManager;
    private $reservationRepository;

    const ALL_RESERVATIONS_URI = "/reservations";
    const SINGLE_RESERVATION_URI = "/reservations/{id}"; 

    public function __construct(ReservationService $reservationService, EntityManagerInterface $manager, ReservationRepository $reservationRepository)
    {
        $this->reservationService = $reservationService;
        $this->reservationEntityManager = $manager;
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * Look for all reservations in database
     * @Get(ReservationRestController::ALL_RESERVATIONS_URI)
     * @param ReservationRepository $reservationRepository
     * @return Response
     */
    public function findAllReservations(){
        $reservations = $this->reservationService->findAllReservations();
        if(empty($reservations)){
            return View::create(null, Response::HTTP_NO_CONTENT);
        }
        return View::create($reservations, Response::HTTP_OK);
    }

    /**
     * Create a new reservation in database
     * @POST(ReservationRestController::ALL_RESERVATIONS_URI)
     * @ParamConverter("reservationDTO", converter="fos_rest.request_body")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function createReservation(ReservationDTO $reservationDTO){
        try{
            $this->reservationService->addNewReservation($reservationDTO);
        } catch (Exception $e){
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_CREATED);
    }

    /**
     * Modifies a reservation in database
     * @Put(ReservationRestController::SINGLE_RESERVATION_URI)
     * @ParamConverter("reservationDTO", converter="fos_rest.request_body")
     * @param Request $request
     * @param Reservation $reservation
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function updateReservation(ReservationDTO $reservationDTO, int $id){
        try {
            $this->reservationService->updateReservation($id, $reservationDTO);
        } catch (QueryException $qe){
            return View::create("Echec lors de la mise à jour pour la réservation avec l'id $id", Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e){
            return View::create($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}