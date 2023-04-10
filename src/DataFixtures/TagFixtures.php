<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tag;
use App\DataFixtures\PostFixtures;
use App\Repository\PostRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TagFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private PostRepository $postRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        $posts = $this->postRepository->findAll();
        
        $tags = [];
        for ($i = 0; $i < 9; $i++) {
            $tag = new Tag();
            $tag->setName($faker->word());

            $manager->persist($tag);
            $tags[] = $tag;
        }

        foreach ($posts as $post) {
            for ($i = 0; $i < mt_rand(1, 5); $i++) {
                $post->addTag(
                    $tags[mt_rand(0, count($tags) - 1)]
                );
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PostFixtures::class
        ];
    }
}
