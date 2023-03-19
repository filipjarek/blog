<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        $categories = [];
        for ($i = 0; $i < 7; $i++) {
            $category = new Category();
            $category->setName($faker->word())
                ->setIsActive('1');

            $manager->persist($category);
            $categories[] = $category;
        }

        $manager->flush();
    }
}
