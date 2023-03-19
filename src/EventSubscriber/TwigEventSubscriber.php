<?php

namespace App\EventSubscriber;

use Twig\Environment;
use App\Repository\TagRepository;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TwigEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Environment $twig,
        private CategoryRepository $categoryRepository,
        private PostRepository $postRepository,
        private TagRepository $tagRepository,
    ) {
    }
    
    public function onKernelController(ControllerEvent $event): void
    {
        $this->twig->addGlobal('categories', $this->categoryRepository->findAllActiveCategories());
        $this->twig->addGlobal('recentPosts', $this->postRepository->findRecentActivePosts());
        $this->twig->addGlobal('tags', $this->tagRepository->findAll());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
