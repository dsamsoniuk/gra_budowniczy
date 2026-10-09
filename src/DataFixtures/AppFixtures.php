<?php

namespace App\DataFixtures;

use App\Entity\Building;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $b = new User();
        $b->setRoles(['ROLE_USER']);

        // $manager->persist($b);

        // $manager->flush();
    }
}
