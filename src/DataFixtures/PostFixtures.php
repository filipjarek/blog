<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Post;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 150; $i++) {
            $post = new Post();
            $post->setTitle($faker->words(4, true))
                ->setPreviewContent($faker->realText(200))
                ->setContent($faker->realText(1800))
                ->setIsActive('1');

            $manager->persist($post);
        }

        $manager->flush();
    }
}
