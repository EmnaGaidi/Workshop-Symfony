<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PersonneFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $fake = Factory::create('fr_FR');
        for ($i=0;$i<20;$i++){
            $personne = new Personne();
            $personne->setNom($fake->name);
            $personne->setPrenom($fake->firstName);
            $personne->setCin($fake->numberBetween());
            $personne->setAge($fake->numberBetween(10,60));
            $personne->setPath($fake->address);
            $manager->persist($personne);
        }

        $manager->flush();
    }
}
