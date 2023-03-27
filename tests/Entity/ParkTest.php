<?php

namespace App\Tests\Entity;

use App\Entity\Park;
use PHPUnit\Framework\TestCase;

class ParkTest extends TestCase
{
    public function testGetSetName(): void
    {
        $parkName = 'Europa Park';
        $park = new Park();
        $park->setName($parkName);

        $this->assertIsString($park->getName());
        $this->assertEquals($parkName, $park->getName());
    }

    public function testDisplayType(): void
    {
        $type = 1;
        $park = new Park();
        $park->setType($type);

        $this->assertIsString($park->displayType());
        $this->assertEquals(Park::TYPES[$type], $park->displayType());
    }
}
