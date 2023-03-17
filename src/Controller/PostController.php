<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends AbstractController
{
    #[Route('/post/{slug}', name: 'app_post')]
    public function index(string $slug, PostRepository $postRepository): Response
    {
        $post = $postRepository->findOnePostBySlug($slug);
        
        return $this->render('post/index.html.twig', [
            'categorySlug' => $post->getCategory()->getSlug(),
            'post' => $post,
        ]);
    }
}
