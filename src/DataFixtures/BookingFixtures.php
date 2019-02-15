<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\Classes;
use App\Entity\Flight;
use App\Entity\Luggage;
use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class BookingFixtures extends Fixture implements DependentFixtureInterface
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
        /** @var Classes[] $models */
        $classes = $manager->getRepository(Classes::class)->findAll();
        /** @var Luggage[] $company */
        $luggages = $manager->getRepository(Luggage::class)->findAll();
        /** @var Flight[] $flights */
        $flights = $manager->getRepository(Flight::class)->findAll();
        /** @var User[] $users */
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            /** @var Booking $booking */
            $booking = new Booking();
            $booking->setReference($faker->numberBetween(1000, 2000));

            shuffle($flights);
            $booking->setFlight($flights[0]);

            shuffle($classes);
            $booking->setClass($classes[0]);

            shuffle($luggages);
            $booking->setLuggages($luggages[0]);

            $booking->setStatus('processing');
            $booking->setBookingDate($faker->dateTime('now'));

            shuffle($users);
            $booking->setCustomer($users[0]);
            /** @var Ticket $ticket */
            $ticket = new Ticket();
            $ticket->setCustomer($users[0]);
            $ticket->setReference($faker->numberBetween(1000, 2000));
            $ticket->setFlight($flights[0]);
            /** @var int $maxSit */
            $maxSit = $flights[0]->getPlane()->getModel()->getSits();
            $ticket->setSit($faker->numberBetween(1, $maxSit));

            $manager->persist($booking);
            $manager->persist($ticket);
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
            ClassFixtures::class,
            FlightFixtures::class,
            LuggageFixtures::class
        );
    }
}
