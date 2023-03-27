<?php

namespace App\Tests\Service;

use App\Service\FileService;
use App\Tests\Helper\TestHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class FileServiceTest extends KernelTestCase
{
    private static Container $container;
    private static array $config;
    private static FileService $fileService;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        self::$container = static::getContainer();
        self::$config = self::$container->get(ParameterBagInterface::class)->get('file');
        self::$fileService = self::$container->get(FileService::class);
    }

    public function testRemove(): void
    {
        $container = static::getContainer();
        $filesystem = $container->get(Filesystem::class);

        $name = 'test.txt';
        $path = sprintf('%s/%s', self::$config['uploadDirectory'], $name);
        $filesystem->dumpFile($path, "");

        self::$fileService->remove($name);

        $this->assertFileDoesNotExist($path);
    }

    public function testBuildPath(): void
    {
        $name = 'test-file.jpg';
        $realPath = sprintf('%s/%s', self::$config['uploadDirectory'], $name);

        $buildedPath = TestHelper::callMethod(self::$fileService, 'buildPath', [$name]);

        $this->assertEquals($realPath, $buildedPath);
    }
}
