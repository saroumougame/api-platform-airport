<?php

namespace App\DataFixtures;

use App\Entity\Compagny;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CompanyFixtures extends Fixture
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
            /** @var Compagny $company */
            $company = new Compagny();
            $company->setName($faker->company);

            $manager->persist($company);
        }

        $manager->flush();
    }
}
