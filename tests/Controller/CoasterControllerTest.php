<?php

namespace App\Tests\Controller;

use App\Repository\CoasterRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CoasterControllerTest extends WebTestCase
{
    public function testList(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/coaster');

        $this->assertResponseIsSuccessful();

        $coasterRepository = static::getContainer()->get(CoasterRepository::class);
        $nodes = $crawler->filter('.coaster-list > .card');

        $this->assertCount($coasterRepository->count([]), $nodes);
    }
}
