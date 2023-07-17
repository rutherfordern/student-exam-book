<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\StudentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpelStudentCommand extends Command
{
    protected $signature = 'expel:students {name}';

    protected $description = 'Команда удаляет студента из БД вместе с его результатами';

    private StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        parent::__construct();
        $this->studentService = $studentService;
    }

    public function handle(): void
    {
        $name = $this->argument('name');

        $resultDelete = $this->studentService->deleteStudentWithScores($name);

        if (null === $resultDelete) {
            $this->error("Студент {$name} не найден");
        } else {
            $this->info("Студент {$name} и его результаты экзаменов успешно удалены");
            Log::channel('console')->info('Студент {name} и его результаты экзаменов удалены', ['name' => $name]);
        }
    }
}
