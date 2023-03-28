<?php

namespace App\Tests\Repository;

use App\Repository\ParkRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ParkRepositoryTest extends KernelTestCase
{
    private ?object $parkRepository;

    public function setUp(): void
    {
        self::bootKernel();
        $this->parkRepository = static::getContainer()->get(ParkRepository::class);
    }


    public function testCountManufacturers(): void
    {
        $park = $this->parkRepository->findOneBy([]);

        $coasters = $park->getCoasters();
        $manufacturer = [];
        foreach ($coasters as $coaster)
        {
            $manufacturer[] = $coaster->getManufacturer()->getId();
        }
        $manufacturer = array_unique($manufacturer);

        $resultCount = $this->parkRepository->countManufacturers($park);

        $this->assertGreaterThanOrEqual(0, $resultCount);

        $this->assertEquals(count($manufacturer), $resultCount);

    }
}
