<?php

namespace App\Controller;

use App\Repository\TagRepository;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    public function __construct(
        protected PaginatorInterface $paginator,
        protected PostRepository $postRepository,
        protected TagRepository $tagRepository,
    ) {
    }

    #[Route('/tag/{slug}', name: 'app_tag', methods: ['GET'])]
    public function index(string $slug, Request $request): Response
    {
        $tag = $this->tagRepository->findOneBySlug($slug);

        $posts = $this->paginator->paginate(
            $this->postRepository->findAllPostsByTag($slug),
            $request->query->getInt('page', 1)
        );

        return $this->render('tag/index.html.twig', [
            'tag' => $tag,
            'posts' => $posts,
        ]);
    }
}
