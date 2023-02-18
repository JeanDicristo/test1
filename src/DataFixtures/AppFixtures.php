<?php

namespace App\DataFixtures;

use App\Entity\Plat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{

    private Generator $faker;

    public function __construct() {
        $this->faker = Factory::create('fr-FR');
    }

    public function load(ObjectManager $manager): void
    {
        $plats = [];
        for ($i = 0; $i < 10; $i++) {
            $plat = new Plat();
            $plat->setTitle($this->faker->word())
                ->setPrice(mt_rand(0, 30))
                ->setDescription($this->faker->text(200))
                ->setImage('https://img.passeportsante.net/1000x526/2021-03-16/i100351-hamburger-maison.jpeg')
                ->setCategory(mt_rand(0, 30));

            $plats[] = $plat;
            $manager->persist($plat);
        }

        $manager->flush();
    }
}
