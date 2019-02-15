<?php

namespace App\DataFixtures;

use App\Entity\Airport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AirportFixtures extends Fixture
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
            /** @var Airport $airport */
            $airport = new Airport();
            $airport->setName($faker->company);

            $manager->persist($airport);
        }

        $manager->flush();
    }
}
