<?php

namespace App\DataFixtures;

use App\Entity\Crew;
use App\Entity\Staff;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CrewFixtures extends Fixture implements DependentFixtureInterface
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
        /** @var Staff[] $staff */
        $staff = $manager->getRepository(Staff::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            /** @var Crew $crew */
            $crew = new Crew();
            $crew->setReference($faker->numberBetween(1000, 2000));

            $crew = $this->addStaff($staff, $crew);

            $manager->persist($crew);
        }

        $manager->flush();
    }

    /**
     * Add five staff to crew
     *
     * @param Staff[] $staff
     * @param Crew $crew
     *
     * @return mixed
     */
    public function addStaff($staff, $crew)
    {
        for ($i = 0; $i < 5; $i++) {
            shuffle($staff);
            $crew->addStaff($staff[0]);
        }

        return $crew;
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
            StaffFixtures::class,
        );
    }
}
