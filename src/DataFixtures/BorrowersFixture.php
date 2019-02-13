<?php

namespace App\DataFixtures;

use App\Entity\Borrowers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\CopyBook;
use Faker;



class BorrowersFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {


        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 personnes
        for ($i = 0; $i < 10; $i++) {
            $borrowers = new Borrowers();
            $borrowers->setAddress($faker->address);
            $borrowers->setEmail($faker->email);
            $borrowers->setFirstname($faker->firstName);
            $borrowers->setLastname($faker->lastName);
            $borrowers->setPhone($faker->phoneNumber);
            $this->setReference('borrowers'.$i, $borrowers);

            $manager->persist($borrowers);
        }


        $manager->flush();


    }
}
