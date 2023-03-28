<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ParkControllerTest extends WebTestCase
{
    public function testCreate(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy([
            'email' => 'admin@monde.com',
        ]);
        $client->loginUser($user);

        $client->request('GET', '/park/create');
        $this->assertResponseIsSuccessful();

        $parkName = 'Europa Test';
        $client->submitForm('Enregistrer', [
            'park[name]' => $parkName,
            'park[imageFile]' => 'assets/images/logo.png',
            'park[type]' => 0,
            'park[address][city]' => 'Lille',
            'park[address][country]' => 'CH',
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', $parkName);
    }
}
