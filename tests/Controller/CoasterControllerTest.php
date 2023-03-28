<?php

namespace App\Tests\Controller;

use App\Entity\Coaster;
use App\Repository\CoasterRepository;
use App\Repository\ManufacturerRepository;
use App\Repository\ParkRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CoasterControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testList(): void
    {
        $crawler = $this->client->request('GET', '/coaster');

        $this->assertResponseIsSuccessful();

        $coasterRepository = static::getContainer()->get(CoasterRepository::class);
        $nodes = $crawler->filter('.coaster-list > .card');

        $this->assertCount($coasterRepository->count([]), $nodes);
    }

    public function testEdit(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy([
            'email' => 'georges.pichon@outlook.com',
        ]);
        $this->client->loginUser($user);

        $manufacturerRepository = static::getContainer()->get(ManufacturerRepository::class);
        $parkRepository = static::getContainer()->get(ParkRepository::class);
        $coasterRepository = static::getContainer()->get(CoasterRepository::class);

        $coaster = new Coaster();
        $coaster->setName("Coaster Test")
            ->setMinimumHeight(100)
            ->setMaximumHeight(200)
            ->setDuration(new DateTime("00:02:00"))
            ->setOpenedAt(new DateTime("2010-01-01"))
            ->setImage('assets/images/logo.png')
            ->setManufacturer($manufacturerRepository->findOneBy([]))
            ->setPark($parkRepository->findOneBy([]));

        $coasterRepository->save($coaster, true);

        $coaster = $coasterRepository->findOneBy([
            'name' => "Coaster Test",
        ]);

        $this->client->request('GET', sprintf("coaster/%s/edit",$coaster->getId()));

        $this->assertResponseIsSuccessful();

        $this->client->submitForm('Enregistrer', [
            'coaster[name]' => "Coaster Test Edited",
            'coaster[minimumHeight]' => 150,
            'coaster[maximumHeight]' => 160,
            'coaster[duration][hour]' => 0,
            'coaster[duration][minute]' => 1,
            'coaster[duration][second]' => 1,
            'coaster[openedAt]' => '1999-10-10',
            'coaster[park]' => 2,
            'coaster[manufacturer]' => 2,
            'coaster[tags]' => [0 => '1'],
        ]);

        $this->assertResponseRedirects('/coaster/' . $coaster->getId());

        $coasterEdited = $coasterRepository->findOneBy([
            'name' => "Coaster Test Edited",
        ]);

        $this->assertEquals("Coaster Test Edited", $coasterEdited->getName());
        $this->assertEquals(150, $coasterEdited->getMinimumHeight());
        $this->assertEquals(160, $coasterEdited->getMaximumHeight());
        $this->assertEquals('1999-10-10', $coasterEdited->getOpenedAt()->format('Y-m-d'));
        $this->assertEquals('00:01:01', $coasterEdited->getDuration()->format('H:i:s'));
        $this->assertEquals(2, $coasterEdited->getManufacturer()->getId());
        $this->assertEquals(2, $coasterEdited->getPark()->getId());

        $coasterRepository->remove($coasterEdited, true);

    }
}
