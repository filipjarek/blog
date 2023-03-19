<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Tag;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        $tags = [];
        for ($i = 0; $i < 15; $i++) {
            $tag = new Tag();
            $tag->setName($faker->word());

            $manager->persist($tag);
            $tags[] = $tag;
        }

        $manager->flush();
    }
}
