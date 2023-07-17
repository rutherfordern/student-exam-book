<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Subject;
use App\Repositories\SubjectRepository;
use App\Services\DTO\SubjectCreateDto;
use App\Services\SubjectService;
use PHPUnit\Framework\TestCase;

class SubjectServiceTest extends TestCase
{
    public function testCreateOrGetWithNull(): void
    {
        $subjectRepositoryMock = $this->createMock(SubjectRepository::class);

        $subjectRepositoryMock->expects($this->once())
            ->method('getByName')
            ->with('Физика')
            ->willReturn(null);

        $subjectService = new SubjectService($subjectRepositoryMock);

        $subjectDto = new SubjectCreateDto('Физика');

        $newSubject = $subjectService->createOrGet($subjectDto);

        $this->assertInstanceOf(Subject::class, $newSubject);
        $this->assertEquals('Физика', $newSubject->name);
    }

    public function testCreateOrGet(): void
    {
        $subjectRepositoryMock = $this->createMock(SubjectRepository::class);

        $existingSubject = new Subject();
        $existingSubject->name = 'Физика';

        $subjectRepositoryMock->expects($this->once())
            ->method('getByName')
            ->with('Физика')
            ->willReturn($existingSubject);

        $subjectService = new SubjectService($subjectRepositoryMock);

        $subjectDto = new SubjectCreateDto('Физика');

        $result = $subjectService->createOrGet($subjectDto);

        $this->assertSame($existingSubject, $result);
    }
}
