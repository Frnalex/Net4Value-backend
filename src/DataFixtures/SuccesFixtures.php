<?php

namespace App\DataFixtures;

use App\Entity\Succes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SuccesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($s = 1; $s <= 10; ++$s) {
            $succes = new Succes();

            $succes->setNom("Succès {$s}");
            
            $manager->persist($succes);
        }

        $manager->flush();
    }
}
