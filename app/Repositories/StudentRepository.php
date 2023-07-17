<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentRepository
{
    /**
     * Возвращает студента по его id.
     *
     * @param Student $id id студента
     *
     * @return Student|null возвращает объект студента или null, если студент не найден
     */
    public function getById(Student $id): ?Student
    {
        return Student::find($id);
    }

    /**
     * Возвращает студента по его имени.
     *
     * @param string $name имя студента
     *
     * @return Student|null возвращает объект студента или null, если студент не найден
     */
    public function getByName(string $name): ?Student
    {
        return Student::where('name', $name)->first();
    }

    /**
     * Возвращает студентов с двумя или более двойками.
     *
     * @return array массив студентов с двумя или более двойками
     */
    public function getStudentsWithTwoOrMoreFailures(): array
    {
        $students = Student::select('students.name', DB::raw('COUNT(*) as two_count'))
            ->join('scores', 'students.id', '=', 'scores.student_id')
            ->where('scores.score', '=', 2)
            ->groupBy('students.name')
            ->havingRaw('COUNT(*) >= 2')
            ->get()
            ->toArray();

        return $students;
    }

    public function save(Student $student): void
    {
        $student->save();
    }

    public function delete(Student $student): void
    {
        $student->delete();
    }
}
