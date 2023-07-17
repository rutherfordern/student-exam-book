<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\CsvDataReader;
use App\Services\CsvImporter;
use App\Services\FileDataReaderInterface;
use App\Services\ImporterInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ImporterInterface::class, CsvImporter::class);
        $this->app->bind(FileDataReaderInterface::class, CsvDataReader::class);
    }
}
