<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher){

    }
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail("admin@admin.fr");
        $admin->setFirstname("admin");
        $admin->setLastname("admin");
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $manager->persist($admin);

        $abonnee = new User();
        $abonnee->setEmail('user@user.fr');
        $abonnee->setFirstname('user');
        $abonnee->setLastname('user');
        $abonnee->setRoles(['ROLE_USER']);
        $abonnee->setPassword($this->hasher->hashPassword($abonnee,'user'));
        $manager->persist($abonnee);

        $manager->flush();
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
