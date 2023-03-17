<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends AbstractController
{
    #[Route('/post/{slug}', name: 'app_post', methods: ['GET', 'POST'])]
    public function index(Post $post, string $slug, PostRepository $postRepository, Request $request, EntityManagerInterface $em): Response
    {
        $comment = new Comment();
        $comment->setPost($post);
        

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('app_post', ['slug' => $post->getSlug()]);
        }

        $post = $postRepository->findOnePostBySlug($slug);
        
        return $this->render('post/index.html.twig', [
            'categorySlug' => $post->getCategory()->getSlug(),
            'post' => $post,
            'form' => $form->createView()
        ]);
    }
}
