<?php

namespace App\Service;

class ConversionService
{
    public function convertFeetToMeters(float $feet): float
    {
        $result = $feet / 3.281;
        return round($result, 2);
    }

    public function convertMetersToFeet(float $feet): float
    {
        $result = $feet * 3.281;
        return round($result, 2);
    }

    public function convertKmPerHourToMetersPerSecond(float $kmPerHour): float
    {
        $result = $kmPerHour / 3.6;
        return round($result, 2);
    }

    public function convertMetersPerSecondToKmPerHour(float $metersPerSecond): float
    {
        $result = $metersPerSecond * 3.6;
        return round($result, 2);
    }
}
