<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepository
{
    /**
     * Возвращает предмет по его названию.
     *
     * @param Subject $id Id предмета
     *
     * @return Subject|null Возвращает объект предмета или null, если предмет не найден
     */
    public function getById(Subject $id): ?Subject
    {
        return Subject::find($id);
    }

    /**
     * Возвращает предмет по его названию.
     *
     * @param string $name Название предмета
     *
     * @return Subject|null Возвращает объект предмета или null, если предмет не найден
     */
    public function getByName(string $name): ?Subject
    {
        return Subject::where('name', $name)->first();
    }

    public function save(Subject $subject): void
    {
        $subject->save();
    }
}
