<?php

namespace App\DataFixtures;

use App\Entity\Staff;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class StaffFixtures extends Fixture
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
            /** @var Staff $staff */
            $staff = new Staff();
            $staff->setFirstname($faker->firstName);
            $staff->setLastname($faker->lastName);
            $staff->setJob($faker->jobTitle);

            $manager->persist($staff);
        }

        $manager->flush();
    }
}
