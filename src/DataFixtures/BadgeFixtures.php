<?php

namespace App\DataFixtures;

use App\Entity\Badge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BadgeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($b = 1; $b <= 5; ++$b) {
            $badge = new Badge();

            $badge->setNom("Badge {$b}");
            
            $manager->persist($badge);
        }

        $manager->flush();
    }
}
