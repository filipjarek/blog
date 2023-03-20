<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        $categories = $this->categoryRepository->findAll();

        foreach ($categories as $category) {
        for ($i = 0; $i < 50; $i++) {
            $post = new Post();
            $post->setTitle($faker->words(4, true))
                ->setPreviewContent($faker->realText(200))
                ->setContent($faker->realText(1500))
                ->setIsActive('1');

            $manager->persist($post);
            $category->addPost($post);
        }
    }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class
        ];
    }
}
