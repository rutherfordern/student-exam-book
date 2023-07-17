<?php

declare(strict_types=1);

namespace App\Services\DTO;

class ScoreCreateDto
{
    private int $student_id;
    private int $subject_id;
    private \DateTime $date;
    private int $score;

    public function __construct(int $student_id, int $subject_id, \DateTime $date, int $score)
    {
        $this->student_id = $student_id;
        $this->subject_id = $subject_id;
        $this->date = $date;
        $this->score = $score;
    }

    public function getStudentId(): int
    {
        return $this->student_id;
    }

    public function getSubjectId(): int
    {
        return $this->subject_id;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
