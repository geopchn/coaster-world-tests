<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;

class ConversionServiceTest extends TestCase
{
    public function testConvertFeetToMeters(): void
    {
        $feet = 25;
        $meters = 7.62;

        $resultMeters = convertFeetToMeters($feet);

        $this->assertEquals($meters, $resultMeters);
    }

    public function testConvertMetersToFeet(): void
    {
        $feet = 25;
        $meters = 7.62;

        $resultFeet = convertMetersToFeet($meters);

        $this->assertEquals($feet, $resultFeet);
    }


    public function testConvertKmPerHourToMetersPerSecond(): void
    {
        $kmPerHour = 3.6;
        $metersPerSecond = 1;

        $resultMetersPerSecond = convertKmPerHourToMetersPerSecond($kmPerHour);

        $this->assertEquals($metersPerSecond, $resultMetersPerSecond);
    }

    public function testConvertMetersPerSecondToKmPerHour(): void
    {
        $kmPerHour = 3.6;
        $metersPerSecond = 1;

        $resultKmPerHour = convertMetersPerSecondToKmPerHour($metersPerSecond);

        $this->assertEquals($kmPerHour, $resultKmPerHour);
    }
}
