<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Hotel;
use App\Entity\Categorie;
use App\Entity\Chambre;
use App\Entity\Tarification;
use App\Entity\Client;
use App\Entity\Reservation;
use DateTime;

class CompleteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $hotel1 = (new Hotel())->setNom("L'Orangerie")->setNumeroAdresse("45")->setNomAdresse("rue de la Barre")->setVille("Lille")
                               ->setCodePostal("59800")->setPays("France")->setEmail("hotel.orangerie@gmail.com")->setTelephone("03.20.03.20.52");
        $manager->persist($hotel1);

        $hotel2 = (new Hotel())->setNom("Le Duret")->setNumeroAdresse("12")->setNomAdresse("molenmeers")->setVille("Bruges")
                               ->setCodePostal("8000")->setPays("Belgique")->setEmail("hotel.duret@gmail.com")->setTelephone("+32 50 34 64 14");
        $manager->persist($hotel2);

        $hotel3 = (new Hotel())->setNom("Le French")->setNumeroAdresse("5")->setNomAdresse("via Mario de' Fiori")->setVille("Rome")
                               ->setCodePostal("00187")->setPays("Italie")->setEmail("hotel.french@gmail.com")->setTelephone("+39 06 6992 3793");
        $manager->persist($hotel3);

        $categorie1 = (new Categorie())->setNbPersonnes(4)->setLitSimple(2)->setLitDouble(1)->setLitKing(null)->setNom("La Familiale");
        $manager->persist($categorie1);
        $categorie2 = (new Categorie())->setNbPersonnes(2)->setLitSimple(null)->setLitDouble(null)->setLitKing(1)->setNom("La Luxe");
        $manager->persist($categorie2);
        $categorie3 = (new Categorie())->setNbPersonnes(1)->setLitSimple(1)->setLitDouble(null)->setLitKing(null)->setNom("La Simple");
        $manager->persist($categorie3);

        $tarification1 = (new Tarification())->setTarif(100)->setHotel($hotel1)->setCategorie($categorie1);
        $manager->persist($tarification1);
        $tarification2 = (new Tarification())->setTarif(200)->setHotel($hotel1)->setCategorie($categorie2);
        $manager->persist($tarification2);
        $tarification3 = (new Tarification())->setTarif(60)->setHotel($hotel1)->setCategorie($categorie3);
        $manager->persist($tarification3);
        $tarification4 = (new Tarification())->setTarif(125)->setHotel($hotel2)->setCategorie($categorie1);
        $manager->persist($tarification4);
        $tarification5 = (new Tarification())->setTarif(250)->setHotel($hotel2)->setCategorie($categorie2);
        $manager->persist($tarification5);
        $tarification6 = (new Tarification())->setTarif(70)->setHotel($hotel2)->setCategorie($categorie3);
        $manager->persist($tarification6);
        $tarification7 = (new Tarification())->setTarif(150)->setHotel($hotel3)->setCategorie($categorie1);
        $manager->persist($tarification7);
        $tarification8 = (new Tarification())->setTarif(220)->setHotel($hotel3)->setCategorie($categorie2);
        $manager->persist($tarification8);
        $tarification9 = (new Tarification())->setTarif(60)->setHotel($hotel3)->setCategorie($categorie3);
        $manager->persist($tarification9);
        
        $chambre1 = (new Chambre())->setNumeroChambre(100)->setHotel($hotel1)->setCategorie($categorie1);
        $manager->persist($chambre1);
        $chambre2 = (new Chambre())->setNumeroChambre(101)->setHotel($hotel1)->setCategorie($categorie2);
        $manager->persist($chambre2);
        $chambre3 = (new Chambre())->setNumeroChambre(102)->setHotel($hotel1)->setCategorie($categorie3);
        $manager->persist($chambre3);

        $chambre4 = (new Chambre())->setNumeroChambre(100)->setHotel($hotel2)->setCategorie($categorie1);
        $manager->persist($chambre4);
        $chambre5 = (new Chambre())->setNumeroChambre(101)->setHotel($hotel2)->setCategorie($categorie2);
        $manager->persist($chambre5);
        $chambre6 = (new Chambre())->setNumeroChambre(102)->setHotel($hotel2)->setCategorie($categorie3);
        $manager->persist($chambre6);

        $chambre7 = (new Chambre())->setNumeroChambre(100)->setHotel($hotel3)->setCategorie($categorie1);
        $manager->persist($chambre7);
        $chambre8 = (new Chambre())->setNumeroChambre(101)->setHotel($hotel3)->setCategorie($categorie2);
        $manager->persist($chambre8);
        $chambre9 = (new Chambre())->setNumeroChambre(102)->setHotel($hotel3)->setCategorie($categorie3);
        $manager->persist($chambre9);

        $client1 = (new Client())->setNom("Laporte")->setPrenom("Thierry")->setEmail("thierry.laporte@wanadoo.fr")
                                 ->setTelephone("0605222829")->setNumeroAdresse("12")->setNomAdresse("avenue de la Liberté")
                                 ->setVille("Lyon")->setCodePostal("69000")->setPays("France");
        $manager->persist($client1);

        $client2 = (new Client())->setNom("Michel")->setPrenom("Patricia")->setEmail("patricia.michel@gmail.fr")
                                 ->setTelephone("0705226429")->setNumeroAdresse("148")->setNomAdresse("rue des Peupliers")
                                 ->setVille("Lille")->setCodePostal("59000")->setPays("France");
        $manager->persist($client2);

        $client3 = (new Client())->setNom("Sanchez")->setPrenom("José")->setEmail("jose.sanchez@hotmail.fr")
                                 ->setTelephone("0647484521")->setNumeroAdresse("8")->setNomAdresse("rue de la Bicyclette")
                                 ->setVille("Paris")->setCodePostal("75016")->setPays("France");
        $manager->persist($client3);

        $dateDebut = new DateTime("2020-05-01");
        $dateFin = new DateTime("2020-05-02");
        $interval = date_diff($dateDebut, $dateFin);
        $reservation1 = (new Reservation())->setDateDebut($dateDebut)->setDateFin($dateFin)->setNbNuitees($interval->format('%a'))
                                           ->setClient($client1)->setChambre($chambre5);
                                           $reservation1->setPrixTotal($reservation1->getNbNuitees() * $tarification4->getTarif());
        $manager->persist($reservation1);

        $reservation2 = (new Reservation())->setDateDebut($dateDebut)->setDateFin($dateFin)->setNbNuitees($interval->format('%a'))
                                           ->setClient($client2)->setChambre($chambre2);
                                           $reservation2->setPrixTotal($reservation2->getNbNuitees() * $tarification1->getTarif());
        $manager->persist($reservation2);

        $dateDebut = new DateTime("2020-05-01");
        $dateFin = new DateTime("2020-05-04");
        $interval = date_diff($dateDebut, $dateFin);
        
        $reservation3 = (new Reservation())->setDateDebut($dateDebut)->setDateFin($dateFin)->setNbNuitees($interval->format('%a'))
                                           ->setClient($client3)->setChambre($chambre8);
                                           $reservation3->setPrixTotal($reservation3->getNbNuitees() * $tarification8->getTarif());
        $manager->persist($reservation3);

        $manager->flush();
    }
}
