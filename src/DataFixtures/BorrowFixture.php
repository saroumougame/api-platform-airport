<?php

namespace App\DataFixtures;

use App\Entity\Borrow;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use App\DataFixtures\BorrowersFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class BorrowFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {


        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 personnes
        for ($i = 0; $i < 10; $i++) {
            $borrow = new Borrow();
            $borrow->setState($faker->numberBetween(0,1));
            $borrow->setReturnDate($faker->dateTime);
            $borrow->setBorrowingDate($faker->dateTime);
            $borrow->setBorrowersId($this->getReference('borrowers'.$i,$borrow));
            $this->setReference('borrow'.$i, $borrow);
            $manager->persist($borrow);
        }


        $manager->flush();


    }


    public function getDependencies()
    {
        return array(
            BorrowersFixture::class,
        );
    }

}
