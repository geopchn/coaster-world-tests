<?php

namespace App\Tests\Repository;

use App\Repository\CoasterRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CoasterRepositoryTest extends KernelTestCase
{
    private ?object $coasterRepository;

    public function setUp(): void
    {
        self::bootKernel();
        $this->coasterRepository = static::getContainer()->get(CoasterRepository::class);
    }

    public function testFindSimilar(): void
    {
        $coaster = $this->coasterRepository->findOneBy([]);

    }
}
