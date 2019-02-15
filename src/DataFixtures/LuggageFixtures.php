<?php

namespace App\DataFixtures;

use App\Entity\Luggage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class LuggageFixtures extends Fixture
{
    /**
     * Load fixture function
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        /** @var Faker\Generator $faker */
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            /** @var Luggage $luggage */
            $luggage = new Luggage();
            $luggage->setReference($faker->numberBetween(1000, 2000));
            $luggage->setName('Luggage set ' . $i);
            $luggage->setWeight($faker->numberBetween(5, 35));

            $manager->persist($luggage);
        }

        $manager->flush();
    }
}
