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


        $admin = new User();
        $admin->setNom('Houvenaeghel')->setPrenom('Margot');
        $admin->setEmail('Houvenaeghel@hotmail.fr');
        $encodedAdmin = $this->encoder->hashPassword($admin, '123');
        $admin->setPassword($encodedAdmin);
        $admin->setRoles(['ROLE_ADMIN']);


        $employee = new User();
        $employee->setNom('Aimar')->setPrenom('Amelie');
        $employee->setEmail('Aimar@hotmail.fr');
        $encodedEmployee = $this->encoder->hashPassword($employee, '123');
        $employee->setPassword($encodedEmployee);
        $employee->setRoles(['ROLE_EMPLOYEE']);


        $manager->persist($user);
        $manager->persist($admin);
        $manager->persist($employee);

        $manager->flush();
    }
}
