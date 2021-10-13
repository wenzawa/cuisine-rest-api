<?php

namespace App\DataFixtures;

use App\Entity\Recette;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        for ($r = 0; $r < 50; $r++) {
            $recette = new Recette;
            $recette->setTitre($faker->realText($faker->numberBetween(10, 20)));
            $recette->setSousTitre($faker->realText($faker->numberBetween(10, 20)));
            $recette->setIngrediens($faker->lastname);
            $manager->persist($recette);
        }
        $manager->flush();
    }
}
