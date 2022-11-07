<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class FileService
{
    private Filesystem $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }


}
