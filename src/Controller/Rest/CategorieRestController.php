<?php

namespace App\Controller\Rest;

use App\DTO\CategorieDTO;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Service\CategorieService;
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


class CategorieRestController extends AbstractFOSRestController {

    private $categorieService;
    private $categorieEntityManager;
    private $categorieRepository;

    const ALL_CATEGORIES_URI = "/categories";
    const ALL_CATEGORIES_BY_HOTEL_URI = "/categories/hotel/{idHotel}";
    const SINGLE_CATEGORIE_URI = "/categories/{id}"; 

    public function __construct(CategorieService $categorieService, EntityManagerInterface $manager, CategorieRepository $categorieRepository)
    {
        $this->categorieService = $categorieService;
        $this->categorieEntityManager = $manager;
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * Look for all categories in database
     * @Get(CategorieRestController::ALL_CATEGORIES_URI)
     * @param CategorieRepository $categorieRepository
     * @return Response
     */
    public function findAllCategories(){
        $categories = $this->categorieService->findAllCategories();
        if(empty($categories)){
            return View::create(null, Response::HTTP_NO_CONTENT);
        }
        return View::create($categories, Response::HTTP_OK);
    }

    /**
     * Look for all categories for a specific hotel in database
     * @Get(CategorieRestController::ALL_CATEGORIES_URI)
     * @param CategorieRepository $categorieRepository
     * @return Response
     */
    public function findAllCategoriesByHotel(int $idHotel){
        $categories = $this->categorieService->findAllCategoriesByHotel($idHotel);
        if(empty($categories)){
            return View::create(null, Response::HTTP_NO_CONTENT);
        }
        return View::create($categories, Response::HTTP_OK);
    }

    /**
     * Create a new categorie in database
     * @POST(CategorieRestController::ALL_CATEGORIES_URI)
     * @ParamConverter("categorieDTO", converter="fos_rest.request_body")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function createCategorie(CategorieDTO $categorieDTO){
        try{
            $this->categorieService->addNewCategorie($categorieDTO);
        } catch (Exception $e){
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_CREATED);
    }

    /**
     * Modifies a categorie in database
     * @Put(CategorieRestController::SINGLE_CATEGORIE_URI)
     * @ParamConverter("categorieDTO", converter="fos_rest.request_body")
     * @param Request $request
     * @param Categorie $categorie
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function updateCategorie(CategorieDTO $categorieDTO, int $id){
        try {
            $this->categorieService->updateCategorie($id, $categorieDTO);
        } catch (QueryException $qe){
            return View::create("Echec lors de la mise à jour pour la catégorie avec l'id $id", Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e){
            return View::create($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}