<?php

namespace App\DataFixtures;

use App\Entity\Formateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FormateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $fake = Factory::create('fr_FR');
        for ($i=0;$i<20;$i++){
            $formateur = new Formateur();
            $formateur->setSpecialite($fake->domainName);
        }

        $manager->flush();
    }
}
