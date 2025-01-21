<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setNom('Sa Bento')->setPrenom('Tony');
        $user->setEmail('pelicarpa@hotmail.fr');
        $encoded = $this->encoder->hashPassword($user, '123');
        $user->setPassword($encoded);
        $user->setRoles(['ROLE_USER']);


        $manager->persist($user);

        $manager->flush();
    }
}
