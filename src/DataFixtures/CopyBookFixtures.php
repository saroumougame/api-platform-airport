<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\CopyBook;
use Faker;



class CopyBookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {


        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 personnes
        for ($i = 0; $i < 10; $i++) {
            $copybook = new CopyBook();
            $copybook->setCopyBookNumber($faker->numberBetween(1, 10));
          //  $copybook->setBookId(1);
          //  $copybook->setBookId($this->getReference('book'.$i, $copybook));
            $this->setReference('copybook'.$i, $copybook);
            $manager->persist($copybook);
        }


        $manager->flush();


    }
}
