<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Student;
use App\Repositories\StudentRepository;
use App\Services\DTO\StudentCreateDto;
use App\Services\StudentService;
use PHPUnit\Framework\TestCase;

class StudentServiceTest extends TestCase
{
    public function testCreateOrGetWithNull(): void
    {
        $studentRepositoryMock = $this->createMock(StudentRepository::class);

        $studentRepositoryMock->expects($this->once())
            ->method('getByName')
            ->with('Петров Павел')
            ->willReturn(null);

        $studentService = new StudentService($studentRepositoryMock);

        $studentDto = new StudentCreateDto('Петров Павел');

        $newStudent = $studentService->createOrGet($studentDto);

        $this->assertInstanceOf(Student::class, $newStudent);
        $this->assertEquals('Петров Павел', $newStudent->name);
    }

    public function testCreateOrGet(): void
    {
        $studentRepositoryMock = $this->createMock(StudentRepository::class);

        $existingStudent = new Student();
        $existingStudent->name = 'Петров Павел';

        $studentRepositoryMock->expects($this->once())
            ->method('getByName')
            ->with('Петров Павел')
            ->willReturn($existingStudent);

        $studentService = new StudentService($studentRepositoryMock);

        $studentDto = new StudentCreateDto('Петров Павел');

        $result = $studentService->createOrGet($studentDto);

        $this->assertSame($existingStudent, $result);
    }
}
