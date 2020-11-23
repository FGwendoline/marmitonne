<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Recette;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecetteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $entree = (new Categorie())->SetNom('Entrée');
        $plat = (new Categorie())->SetNom('Plat');
        $dessert = (new Categorie())->SetNom('Dessert');

        $manager->persist($entree);
        $manager->persist($plat);
        $manager->persist($dessert);

        $manager->flush();
        

        for ($i=0; $i <= 50 ; $i++) { 
            $recette = new Recette();
            $recette
                ->setTitre("titre {$i}")
                ->setResume("resume {$i}")
                ->setPreparation("prepa {$i}")
                ->setTemps("{$i} min")
                ->setPersonnes($i)
                ->setCreatedAt(new \DateTime())
                ->setCategorie($dessert);

            $manager->persist($recette);
        }
       


        $manager->flush();
    }
}
