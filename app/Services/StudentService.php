<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Student;
use App\Repositories\StudentRepository;
use App\Services\DTO\StudentCreateDto;

class StudentService
{
    private StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Создает нового студента или возвращает существующего.
     *
     * @param StudentCreateDto $dto Объект DTO, содержащий информацию о студенте
     *
     * @return Student Возвращает созданного или существующего студента
     */
    public function createOrGet(StudentCreateDto $dto): Student
    {
        $student = $this->studentRepository->getByName($dto->getName());

        if ($student) {
            return $student;
        }

        $newStudent = new Student();
        $newStudent->name = $dto->getName();
        $this->studentRepository->save($newStudent);

        return $newStudent;
    }

    /**
     * Удаляет студента из БД вместе с его результатами или возвращает null если студент не найден.
     *
     * @param string $name Имя студента
     */
    public function deleteStudentWithScores(string $name): ?bool
    {
        $student = $this->studentRepository->getByName($name);

        if ($student) {
            $student->scores()->delete();
            $this->studentRepository->delete($student);

            return true;
        }

        return null;
    }
}
