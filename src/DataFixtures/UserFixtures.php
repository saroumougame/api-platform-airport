<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface $encoder */
    private $encoder;

    /**
     * UserFixtures constructor
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

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
            /** @var User $user */
            $user = new User();
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setEmail($faker->email);

            $password = $this->encoder->encodePassword($user, 'toto');
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
