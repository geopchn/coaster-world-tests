<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    private Filesystem $filesystem;
    private array $config;

    public function __construct(Filesystem $filesystem, ParameterBagInterface $parameterBag)
    {
        $this->filesystem = $filesystem;
        $this->config = $parameterBag->get("file");
    }

    public function upload(UploadedFile $file, string $prefix = "file"): string
    {
        $name = $this->generateName($prefix, $file->guessExtension());
        $file->move($this->config["uploadDirectory"], $name);
        return $name;
    }

    public function remove(string $name): void
    {
        $path = sprintf("%s/%s", $this->config["uploadDirectory"], $name);
        $this->filesystem->remove($path);
    }

    private function generateName(string $prefix, string $extension): string
    {
        $uniqueValue = uniqid(sprintf('%s-', $prefix));
        return sprintf("%s.%s", $uniqueValue, $extension);
    }
}
