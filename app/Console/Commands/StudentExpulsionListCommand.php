<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Repositories\StudentRepository;
use Illuminate\Console\Command;

class StudentExpulsionListCommand extends Command
{
    protected $signature = 'student:explusion:list';

    protected $description = 'Команда выводит таблицу студентов с двумя и более двойками';

    private StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        parent::__construct();
        $this->studentRepository = $studentRepository;
    }

    public function handle(): void
    {
        $students = $this->studentRepository->getStudentsWithTwoOrMoreFailures();

        $this->table(['Student', 'Score'], $students);
    }
}
