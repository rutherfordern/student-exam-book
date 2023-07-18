<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\ScoreService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CalculateAverageScoreCommand extends Command
{
    protected $signature = 'avg:scores {subject}';

    protected $description = 'Команда выводит средний бал студентов по переданному предмету';

    private ScoreService $scoreService;

    public function __construct(ScoreService $scoreService)
    {
        parent::__construct();
        $this->scoreService = $scoreService;
    }

    public function handle(): void
    {
        $subject = $this->argument('subject');

        $averageScore = $this->scoreService->calculateAverageScoreBySubject($subject);

        if (null === $averageScore) {
            $this->error("Предмет {$subject} не найден");
        } else {
            $this->info("Средний бал всех студентов по предмету {$subject}: {$averageScore}");
        }
    }
}
