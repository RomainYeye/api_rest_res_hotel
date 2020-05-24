<?php

namespace App\Controller\Rest;

use App\DTO\HotelDTO;
use App\Entity\Hotel;
use App\Repository\HotelRepository;
use App\Service\HotelService;
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


class HotelRestController extends AbstractFOSRestController {

    private $hotelService;
    private $hotelEntityManager;
    private $hotelRepository;

    const SINGLE_HOTEL_URI = "/hotels/{id}"; 
    const ALL_HOTELS_URI = "/hotels";
    const ALL_HOTELS_BY_PAYS_URI = "/hotels/pays/{pays}";
    const ALL_HOTELS_BY_VILLE_URI = "/hotels/ville/{ville}";
    const ALL_CATEGORIES_BY_HOTEL_URI = "/hotels/{idHotel}/categories";
    const ALL_AVAILABLE_CHAMBRES_BY_DATES = "hotels/{idHotel}/categories/{idCategorie}/begin/{dateDebut}/end/{dateFin}";

    public function __construct(HotelService $hotelService, EntityManagerInterface $manager, HotelRepository $hotelRepository)
    {
        $this->hotelService = $hotelService;
        $this->hotelEntityManager = $manager;
        $this->hotelRepository = $hotelRepository;
    }

    /**
     * Look for one specific hotel in database
     * @Get(HotelRestController::SINGLE_HOTEL_URI)
     * @param HotelRepository $hotelRepository
     * @return Response
     */
    public function findOneSpecificHotel(int $id){
        $hotel = $this->hotelService->findOneSpecificHotel($id);
        if(empty($hotel)){
            return View::create(null, Response::HTTP_NO_CONTENT);
        }
        return View::create($hotel, Response::HTTP_OK);
    }

    /**
     * Look for all hotels in database
     * @Get(HotelRestController::ALL_HOTELS_URI)
     * @param HotelRepository $hotelRepository
     * @return Response
     */
    public function findAllHotels(){
        $hotels = $this->hotelService->findAllHotels();
        if(empty($hotels)){
            return View::create(null, Response::HTTP_NO_CONTENT);
        }
        return View::create($hotels, Response::HTTP_OK);
    }

    /**
     * Look for all hotels for a specific country in database
     * @Get(HotelRestController::ALL_HOTELS_BY_PAYS_URI);
     * @param HotelRepository $hotelRepository
     * @return Response
     */
    public function findAllHotelsByPays(string $pays){
        $hotels = $this->hotelService->findAllHotelsByPays($pays);
        if(empty($hotels)){
            return View::create(null, Response::HTTP_NO_CONTENT);
        }
        return View::create($hotels, Response::HTTP_OK);
    }

    /**
     * Look for all hotels for a specific city in database
     * @Get(HotelRestController::ALL_HOTELS_BY_VILLE_URI);
     * @param HotelRepository $hotelRepository
     * @return Response
     */
    public function findAllHotelsByVille(string $ville){
        $hotels = $this->hotelService->findAllHotelsByVille($ville);
        if(empty($hotels)){
            return View::create(null, Response::HTTP_NO_CONTENT);
        }
        return View::create($hotels, Response::HTTP_OK);
    }

    /**
     * Look if chambres for a specific categorie in a specific hotel are available in database
     * @Get(HotelRestController::ALL_AVAILABLE_CHAMBRES_BY_DATES);
     * @param HotelRepository $hotelRepository
     * @return Response
     */
    public function findAllChambresAvailableByDates(int $idHotel, int $idCategorie, string $dateDebut, string $dateFin){
        $chambres = $this->hotelService->findAllChambresAvailableByDates($idHotel, $idCategorie, $dateDebut, $dateFin);
        if(empty($chambres)){
            return View::create(null, Response::HTTP_NO_CONTENT);
        }
        return View::create($chambres, Response::HTTP_OK);
    }

    /**
     * Look for all categories for a specific hotel in database
     * @Get(HotelRestController::ALL_CATEGORIES_BY_HOTEL_URI);
     * @param HotelRepository $hotelRepository
     * @return Response
     */
    public function findAllCategoriesByHotel(int $idHotel){
        $categories = $this->hotelService->findAllCategoriesByHotel($idHotel);
        if(empty($categories)){
            return View::create(null, Response::HTTP_NO_CONTENT);
        }
        return View::create($categories, Response::HTTP_OK);
    }

    /**
     * Create a new hotel in database
     * @POST(HotelRestController::ALL_HOTELS_URI)
     * @ParamConverter("hotelDTO", converter="fos_rest.request_body")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function createHotel(HotelDTO $hotelDTO){
        try{
            $this->hotelService->addNewHotel($hotelDTO);
        } catch (Exception $e){
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_CREATED);
    }

    /**
     * Modifies a hotel in database
     * @Put(HotelRestController::SINGLE_HOTEL_URI)
     * @ParamConverter("hotelDTO", converter="fos_rest.request_body")
     * @param Request $request
     * @param Hotel $hotel
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function updateHotel(HotelDTO $hotelDTO, int $id){
        try {
            $this->hotelService->updateHotel($id, $hotelDTO);
        } catch (QueryException $qe){
            return View::create("Echec lors de la mise à jour pour l'hôtel avec l'id $id", Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e){
            return View::create($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}