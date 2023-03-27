<?php

namespace App\Tests\Service;

use App\Entity\Address;
use App\Service\WeatherService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WeatherServiceTest extends KernelTestCase
{
    public function testGetForecastByAddress(): void
    {
        self::bootKernel();
        $weatherService = static::getContainer()->get(WeatherService::class);

        $address = new Address();
        $address->setCity('Lille')->setCountry('FR');
        $result = $weatherService->getForecastByAddress($address);

        $this->assertIsArray($result);
        $this->assertGreaterThan(5, count($result));

        $firstEntry = reset($result);
        $this->assertArrayHasKey('id', $firstEntry);
        $this->assertArrayHasKey('date', $firstEntry);
        $this->assertArrayHasKey('label', $firstEntry);
        $this->assertArrayHasKey('temperature', $firstEntry);

        $this->assertEquals(DateTime::class, get_class($firstEntry['date']));
    }
}
