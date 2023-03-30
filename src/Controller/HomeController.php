<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(Request $request, PostRepository $postRepository, PaginatorInterface $paginator): Response
    {
        $posts = $paginator->paginate(
            $postRepository->findAllActivePostsOrderedByNewest(),
            $request->query->getInt('page', 1),
            5
        );
        
        return $this->render('home/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
