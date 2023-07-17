<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Score;

class ScoreRepository
{
    /**
     * Возвращает только оценки по указанному предмету.
     *
     * @param string $subjectName Название предмета
     *
     * @return array Массив оценок по предмету
     */
    public function getOnlyScoresBySubject(string $subjectName): array
    {
        $scores = Score::whereHas('subject', function ($query) use ($subjectName) {
            $query->where('name', $subjectName);
        })->pluck('score')->all();

        return $scores;
    }

    /**
     * Возвращает оценки с именем и датой по указанному предмету.
     *
     * @param string $subjectName Название предмета
     *
     * @return array Массив оценок с именем и датой по предмету
     */
    public function getScoresWithNameAndDateBySubject(string $subjectName): array
    {
        $scores = Score::join('students', 'scores.student_id', '=', 'students.id')
            ->join('subjects', 'scores.subject_id', '=', 'subjects.id')
            ->where('subjects.name', $subjectName)
            ->select('students.name', 'scores.date', 'scores.score')
            ->get()
            ->toArray();

        return $scores;
    }
}
