<?php

declare(strict_types=1);

namespace App\Services;

use League\Csv\Exception;
use League\Csv\Reader;

class CsvDataReader implements FileDataReaderInterface
{
    /**
     * Читает данные из CSV-файла и возвращает итератор записей.
     *
     * @param string $filePath Путь к CSV-файлу
     *
     * @return iterable Итератор записей из CSV-файла
     *
     * @throws Exception
     */
    public function read(string $filePath): iterable
    {
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        return $csv->getRecords();
    }
}
