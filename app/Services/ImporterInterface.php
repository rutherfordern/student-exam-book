<?php

declare(strict_types=1);

namespace App\Services;

interface ImporterInterface
{
    public function import(string $filePath): void;
}
