<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\SecurityBundle\Security;

class SecurityControllerTest extends WebTestCase
{
    public function testLogout(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $security = static::getContainer()->get(Security::class);

        $user = $userRepository->findOneBy([
            'email' => 'georges.pichon@outlook.com',
        ]);

        $client->loginUser($user);
        $this->assertNotNull($security->getUser());

        $client->request('GET', '/logout');

        $client->followRedirect();

        $this->assertNull($security->getUser());
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'Bienvenue sur CoasterWorld');
    }
}
