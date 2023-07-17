<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Repositories\ScoreRepository;
use Illuminate\Console\Command;

class ShowScoresCommand extends Command
{
    protected $signature = 'scores {subject}';

    protected $description = 'Команда выводит оценки студентов по переданному предмету';

    private ScoreRepository $scoreRepository;

    public function __construct(ScoreRepository $scoreRepository)
    {
        parent::__construct();
        $this->scoreRepository = $scoreRepository;
    }

    public function handle(): void
    {
        $subject = $this->argument('subject');

        $scores = $this->scoreRepository->getScoresWithNameAndDateBySubject($subject);

        if (empty($scores)) {
            $this->error("Предмет {$subject} не найден");
        } else {
            $this->table(['Student', 'Date', 'Score'], $scores);
        }
    }
}
