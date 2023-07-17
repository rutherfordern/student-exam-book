<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Score;
use App\Repositories\ScoreRepository;
use App\Services\DTO\ScoreCreateDto;
use Illuminate\Cache\Repository as CacheRepository;

class ScoreService
{
    private ScoreRepository $scoreRepository;
    private CacheRepository $cacheRepository;

    public function __construct(ScoreRepository $scoreRepository, CacheRepository $cacheRepository)
    {
        $this->scoreRepository = $scoreRepository;
        $this->cacheRepository = $cacheRepository;
    }

    public function createOrUpdate(ScoreCreateDto $dto): void
    {
        $existingScore = Score::where('student_id', $dto->getStudentId())
            ->where('subject_id', $dto->getSubjectId())
            ->where('date', $dto->getDate())
            ->first();

        if ($existingScore) {
            $existingScore->score = $dto->getScore();
            $existingScore->save();
        } else {
            $newScore = new Score();
            $newScore->student_id = $dto->getStudentId();
            $newScore->subject_id = $dto->getSubjectId();
            $newScore->date = $dto->getDate();
            $newScore->score = $dto->getScore();
            $newScore->save();
        }
    }

    /**
     * Рассчитывает средний балл по указанному предмету.
     *
     * @param string $subjectName название предмета
     *
     * @return float|null средний балл по предмету или null, если предмета не существует
     */
    public function calculateAverageScoreBySubject(string $subjectName): float|null
    {
        $scores = $this->scoreRepository->getOnlyScoresBySubject($subjectName);

        if (empty($scores)) {
            return null;
        }

        $cacheKey = "avg_scores_{$subjectName}";

        if ($this->cacheRepository->tags([$subjectName])->has($subjectName)) {
            $averageScores = $this->cacheRepository->tags([$subjectName])->get($cacheKey);
        } else {
            $averageScores = collect($scores)->avg();

            $this->cacheRepository->tags([$subjectName])->put($cacheKey, $averageScores);
        }

        return $averageScores;
    }
}
