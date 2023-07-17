<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\ImporterInterface;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;

class ImportFileCommand extends Command
{
    protected $signature = 'import:file {file}';

    protected $description = 'Команда импортирует файл и разделяет его на 3 таблицы';

    private ImporterInterface $importer;
    private LoggerInterface $logger;

    public function __construct(ImporterInterface $importer, LoggerInterface $logger)
    {
        parent::__construct();
        $this->importer = $importer;
        $this->logger = $logger;
    }

    public function handle(): void
    {
        $file = $this->argument('file');

        try {
            $this->importer->import($file);

            $this->logger->info('Команда {signature} выполнена успешно', ['signature' => $this->signature]);

            $this->info('Файл успешно импортирован');
        } catch (\ErrorException $e) {
            $this->logger->error('Произошла ошибка при импорте файла', ['exception' => $e]);
            $this->error('Файл по данному пути не найден');
        }
    }
}
