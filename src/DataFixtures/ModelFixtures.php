<?php

namespace App\DataFixtures;

use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ModelFixtures extends Fixture
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
            /** @var Model $model */
            $model = new Model();
            $model->setName('A' . $faker->numberBetween(300, 380));
            $model->setSits($faker->numberBetween(200, 300));

            $manager->persist($model);
        }

        $manager->flush();
    }
}
