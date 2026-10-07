<?php

namespace App\DataFixtures;

use App\Entity\Building;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $b = new Building();
        // $b->setGoldCost(10);

        // $manager->persist($b);

        // $manager->flush();
    }
}
