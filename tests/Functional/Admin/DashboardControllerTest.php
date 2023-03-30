<?php

namespace App\Tests\Functional\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DashboardControllerTest extends WebTestCase
{
    public function testIfAdminCanAccessToAdminPage(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var UserRepository */
        $userRepository = $client->getContainer()->get(UserRepository::class);

        /** @var User */
        $user = $userRepository->findOneByEmail('admin@gmail.com');

        $client->loginUser($user);

        $crawler = $client->request(Request::METHOD_GET, $urlGeneratorInterface->generate('admin'));
        
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertRouteSame('admin');
    }

    public function testIfUserCanAccessToAdminPage(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var UserRepository */
        $userRepository = $client->getContainer()->get(UserRepository::class);

        /** @var User */
        $user = $userRepository->findOneByEmail('user@gmail.com');

        $client->loginUser($user);

        $crawler = $client->request(Request::METHOD_GET, $urlGeneratorInterface->generate('admin'));
        
        $this->assertResponseStatusCodeSame(403);
    }
}
