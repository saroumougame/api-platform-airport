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
            if ($i == 0) {
                $user->setFirstName('admin');
                $user->setLastName('admin');
                $user->setEmail('admin@test.com');
                $user->setRoles([
                    "ROLE_ADMIN"
                ]);
            } else {
                $user->setFirstName($faker->firstName);
                $user->setLastName($faker->lastName);
                $user->setEmail($faker->email);
                $user->setRoles([
                    "ROLE_USER"
                ]);
            }

            $password = $this->encoder->encodePassword($user, 'toto');
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
