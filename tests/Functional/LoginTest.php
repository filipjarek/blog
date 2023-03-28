<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LoginTest extends WebTestCase
{
    public function testLoginWithGoodCredentials(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGenerator = $client->getContainer()->get('router');

        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_login'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter('form[name=login]')->form([
            '_username' => 'admin@gmail.com',
            '_password' => 'password'
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertRouteSame('app_home');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLoginWithWrongCredentials(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGenerator = $client->getContainer()->get('router');

        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_login'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->filter('form[name=login]')->form([
            '_username' => 'adminnn@gmail.com',
            '_password' => 'passwordddd'
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertRouteSame('app_login');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLogout(): void
    {
        $client = static::createClient();

        /** @var UserRepository */
        $userRepository = $client->getContainer()->get(UserRepository::class);

        /** @var UrlGeneratorInterface */
        $urlGenerator = $client->getContainer()->get('router');

        /** @var User */
        $user = $userRepository->findOneBy([]);

        $client->loginUser($user);

        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_logout'));

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertRouteSame('app_home');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}