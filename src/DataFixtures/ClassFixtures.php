<?php

namespace App\DataFixtures;

use App\Entity\Classes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ClassFixtures extends Fixture
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

        for ($i = 1; $i <= 3; $i++) {
            /** @var Classes $class */
            $class = new Classes();
            $class->setNom($i . 'e class');

            $manager->persist($class);
        }

        $manager->flush();
    }
}
