<?php

namespace App\EventSubscriber;

use Twig\Environment;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TwigEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Environment $twig,
        private CategoryRepository $categoryRepository,
    ) {
    }
    
    public function onKernelController(ControllerEvent $event): void
    {
        $this->twig->addGlobal('categories', $this->categoryRepository->findAllActiveCategories());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
