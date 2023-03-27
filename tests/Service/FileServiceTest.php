<?php

namespace App\Tests\Service;

use App\Service\FileService;
use App\Tests\Helper\TestHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileServiceTest extends KernelTestCase
{
    private Container $container;
    private array $config;
    private FileService $fileService;

    private static string $testFilename;

    public function setUp(): void
    {
        self::bootKernel();
        $this->container = static::getContainer();
        $this->config = $this->container->get(ParameterBagInterface::class)->get('file');
        $this->fileService = $this->container->get(FileService::class);
    }

    public function testUpload(): void
    {
        $filesystem = $this->container->get(Filesystem::class);

        $name = 'test.txt';
        $content = 'bonjour';
        $tempPath = 'data/' . $name;
        $filesystem->dumpFile($tempPath, $content);

        $uploadedFile = new UploadedFile($tempPath, $name, test: true);
        self::$testFilename = $this->fileService->upload($uploadedFile, 'test');

        $this->assertIsString(self::$testFilename);
    }

    /**
     * @depends testUpload
     */
    public function testBuildPath(): void
    {
        $realPath = sprintf('%s/%s', $this->config['uploadDirectory'], self::$testFilename);
        $buildedPath = TestHelper::callMethod($this->fileService, 'buildPath', [self::$testFilename]);

        $this->assertEquals($realPath, $buildedPath);
        $this->assertFileExists($buildedPath);
    }

    /**
     * @depends testBuildPath
     */
    public function testRemove(): void
    {
        $this->fileService->remove(self::$testFilename);

        $buildedPath = TestHelper::callMethod($this->fileService, 'buildPath', [self::$testFilename]);
        $this->assertFileDoesNotExist($buildedPath);
    }
}
