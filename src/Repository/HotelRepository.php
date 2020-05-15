<?php

namespace App\Repository;

use App\Entity\Hotel;
use App\Entity\Chambre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotel[]    findAll()
 * @method Hotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method findAllCategoriesByHotel(int $idHotel)
 * @method findAllChambresAvailableByDates(int $idHotel, int $idCategorie, string $dateDebut, string $dateFin)
 */
class HotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hotel::class);
    }

    // /**
    //  * @return Hotel[] Returns an array of Hotel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hotel
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllCategoriesByHotel(int $idHotel)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery("SELECT c FROM App\Entity\Categorie c
                                              JOIN c.tarifications t
                                              WHERE t.hotel = :hotel")
                                ->setParameter('hotel', $idHotel);
        return $query->getResult();
    }

    private static function compareChambres(Chambre $chambreA, Chambre $chambreB) {
        return $chambreA->getId() <=> $chambreB->getId();
    }

    public function findAllChambresAvailableByDates(int $idHotel, int $idCategorie, string $dateDebut, string $dateFin)
    {
        $entityManager = $this->getEntityManager();

        $query1 = $entityManager->createQuery("SELECT c FROM App\Entity\Chambre c 
                                              WHERE c.hotel = :hotel
                                              AND c.categorie = :categorie")
                                ->setParameters(['hotel' => $idHotel, 'categorie' => $idCategorie]);

        $query2 = $entityManager->createQuery("SELECT c FROM App\Entity\Chambre c
                                              JOIN c.reservations r 
                                              WHERE c.hotel = :hotel
                                              AND c.categorie = :categorie")
                                ->setParameters(['hotel' => $idHotel, 'categorie' => $idCategorie]);
        

        $chambresNeverBooked = array_udiff($query1->getResult(),$query2->getResult(),'self::compareChambres');

        $query3 = $entityManager->createQuery("SELECT c FROM App\Entity\Chambre c
                                              JOIN c.reservations r 
                                              WHERE c.hotel = :hotel
                                              AND c.categorie = :categorie
                                              AND :dateDebut NOT BETWEEN r.dateDebut AND r.dateFin 
                                              AND :dateFin NOT BETWEEN r.dateDebut AND r.dateFin
                                              AND NOT (:dateDebut < r.dateDebut AND :dateFin > r.dateFin) ")
                                ->setParameters(['hotel' => $idHotel, 'categorie' => $idCategorie, 'dateDebut' => $dateDebut, 'dateFin' => $dateFin]);

        $query = array_merge($chambresNeverBooked, $query3->getResult());

        return $query;
    }

}
