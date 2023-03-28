<?php

namespace App\Tests\Service;

use App\Service\ConversionService;
use PHPUnit\Framework\TestCase;

class ConversionServiceTest extends TestCase
{
    private ConversionService $conversionService;

    public function setUp(): void
    {
        $this->conversionService = new ConversionService();
    }

    public function testConvertFeetToMeters(): void
    {
        $feet = 25;
        $meters = 7.62;

        $resultMeters = $this->conversionService->convertFeetToMeters($feet);

        $this->assertEquals($meters, $resultMeters);
    }

    public function testConvertMetersToFeet(): void
    {
        $feet = 25;
        $meters = 7.62;

        $resultFeet = $this->conversionService->convertMetersToFeet($meters);

        $this->assertEquals($feet, $resultFeet);
    }

    public function testConvertKmPerHourToMetersPerSecond(): void
    {
        $kmPerHour = 3.6;
        $metersPerSecond = 1;

        $resultMetersPerSecond = $this->conversionService->convertKmPerHourToMetersPerSecond($kmPerHour);

        $this->assertEquals($metersPerSecond, $resultMetersPerSecond);
    }

    public function testConvertMetersPerSecondToKmPerHour(): void
    {
        $kmPerHour = 3.6;
        $metersPerSecond = 1;

        $resultKmPerHour = $this->conversionService->convertMetersPerSecondToKmPerHour($metersPerSecond);

        $this->assertEquals($kmPerHour, $resultKmPerHour);
    }
}
