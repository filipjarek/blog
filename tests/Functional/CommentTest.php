<?php

namespace App\Tests\Post;

use App\Entity\Post;
use App\Repository\Post\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CommentTest extends WebTestCase
{
    public function testIfPostCommentWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');

        /** @var PostRepository */
        $postRepository = $em->getRepository(Post::class);

        /** @var Post */
        $post = $postRepository->findOneBy([]);

        $crawler = $client->request(
            Request::METHOD_GET, 
            $urlGeneratorInterface->generate('app_post', ['slug' => $post->getSlug()]));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter('form[name=comment]')->form([
            'comment[author]' => 'Rick',
            'comment[text]' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertRouteSame('app_post', ['slug' => $post->getSlug()]);
        $this->assertSelectorTextContains('div.alert', 'Comment added successfully !');
    }
}