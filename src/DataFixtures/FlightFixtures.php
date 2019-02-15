<?php

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\Crew;
use App\Entity\Flight;
use App\Entity\Plane;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class FlightFixtures extends Fixture implements DependentFixtureInterface
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
        /** @var Airport[] $models */
        $airports = $manager->getRepository(Airport::class)->findAll();
        /** @var Plane[] $company */
        $planes = $manager->getRepository(Plane::class)->findAll();
        /** @var Crew[] $crews */
        $crews = $manager->getRepository(Crew::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            /** @var Flight $flight */
            $flight = new Flight();
            $flight->setReference($faker->numberBetween(1000, 2000));

            shuffle($airports);
            $flight->setArrivalAirport($airports[0]);
            $flight->setDepartureAirport($airports[1]);

            shuffle($crews);
            $flight->setCrew($crews[0]);

            shuffle($planes);
            $flight->setPlane($planes[0]);

            $flight->setDepartureDate($faker->dateTimeBetween('-10 days', 'now'));
            $flight->setArrivalDate($faker->dateTimeBetween('now', '+10 days'));

            $manager->persist($flight);
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
            AirportFixtures::class,
            PlaneFixtures::class,
            CrewFixtures::class
        );
    }
}
