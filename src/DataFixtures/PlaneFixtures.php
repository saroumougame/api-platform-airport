<?php

namespace App\DataFixtures;

use App\Entity\Compagny;
use App\Entity\Model;
use App\Entity\Plane;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PlaneFixtures extends Fixture implements DependentFixtureInterface
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
        /** @var Model[] $models */
        $models = $manager->getRepository(Model::class)->findAll();
        /** @var Compagny[] $company */
        $company = $manager->getRepository(Compagny::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            /** @var Plane $plane */
            $plane = new Plane();
            $plane->setName('Airbus');
            $plane->setReference($faker->numberBetween(1000, 2000));

            shuffle($company);
            $plane->setCompany($company[0]);

            shuffle($models);
            $plane->setModel($models[0]);

            $manager->persist($plane);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            CompanyFixtures::class,
            ModelFixtures::class
        );
    }
}
