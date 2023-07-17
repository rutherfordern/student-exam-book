<?php

declare(strict_types=1);

namespace App\Services;

use League\Csv\Reader;

class CsvDataReader implements FileDataReaderInterface
{
    public function read(string $filePath): iterable
    {
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        return $csv->getRecords();
    }
}
