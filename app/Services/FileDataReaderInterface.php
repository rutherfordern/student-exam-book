<?php

declare(strict_types=1);

namespace App\Services;

interface FileDataReaderInterface
{
    public function read(string $filePath): iterable;
}
