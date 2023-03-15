<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected PaginatorInterface $paginator,
        protected PostRepository $postRepository,
    ) {
    }

    #[Route('/category/{slug}', name: 'app_category')]
    public function index(string $slug, Request $request): Response
    {
        $category = $this->categoryRepository->findOneBySlug($slug);

        $posts = $this->paginator->paginate(
            $this->postRepository->findAllActive($category),
            $request->query->getInt('page', 1)
        );

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'posts' => $posts,
        ]);     
    }
}
