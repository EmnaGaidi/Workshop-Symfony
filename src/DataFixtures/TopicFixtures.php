<?php

namespace App\DataFixtures;

use App\Entity\Topic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TopicFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $fake = Factory::create('fr_FR');
        for ($i=0;$i<20;$i++){
            $topic = new Topic();
            $topic->setDesignation($fake->title);
        }

        $manager->flush();
    }
}
