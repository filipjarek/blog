<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ContactTest extends WebTestCase
{
    public function testIfContactPageWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        $client->request(Request::METHOD_GET, $urlGeneratorInterface->generate('app_contact'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testIfContactFormWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        $crawler = $client->request(Request::METHOD_GET, $urlGeneratorInterface->generate('app_contact'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter('form[name=contact]')->form([
            'contact[fullName]' => "Rick Jones",
            'contact[email]' => "usertest@gmail.com",
            'contact[subject]' => "Test",
            'contact[message]' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        
        $this->assertRouteSame('app_contact');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK); 
    }

    public function testReturnToHomePageWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        $crawler = $client->request(Request::METHOD_GET, $urlGeneratorInterface->generate('app_contact'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $link = $crawler->selectLink('Return to the posts page')->link()->getUri();

        $crawler = $client->request(Request::METHOD_GET, $link);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $this->assertRouteSame('app_home');
    }
}
