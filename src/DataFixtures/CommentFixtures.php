<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Comment;
use App\DataFixtures\PostFixtures;
use App\Repository\PostRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private PostRepository $postRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $posts = $this->postRepository->findAll();

        foreach ($posts as $post) {
            for ($i = 0; $i < mt_rand(0, 10); $i++) {
                $comment = new Comment();
                $comment->setText($faker->realText)
                    ->setIsApproved(mt_rand(0, 1))
                    ->setAuthor($faker->firstname)
                    ->setPost($post);

                $manager->persist($comment);
                $post->addComment($comment);
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

