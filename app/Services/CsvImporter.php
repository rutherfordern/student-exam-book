<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\DTO\ScoreCreateDto;
use App\Services\DTO\StudentCreateDto;
use App\Services\DTO\SubjectCreateDto;
use Psr\Log\LoggerInterface;

class CsvImporter implements ImporterInterface
{
    private StudentService $studentService;
    private SubjectService $subjectService;
    private ScoreService $scoreService;
    private FileDataReaderInterface $fileDataReader;
    private LoggerInterface $logger;

    public function __construct(
        StudentService $studentService,
        SubjectService $subjectService,
        ScoreService $scoreService,
        FileDataReaderInterface $fileDataReader,
        LoggerInterface $logger,
    ) {
        $this->studentService = $studentService;
        $this->subjectService = $subjectService;
        $this->scoreService = $scoreService;
        $this->fileDataReader = $fileDataReader;
        $this->logger = $logger;
    }

    public function import(string $filePath): void
    {
        $records = $this->fileDataReader->read($filePath);

        foreach ($records as $record) {
            $studentDto = new StudentCreateDto($record['ФИО студента']);
            $subjectDto = new SubjectCreateDto($record['Название предмета']);

            $student = $this->studentService->createOrGet($studentDto);

            $subject = $this->subjectService->createOrGet($subjectDto);

            $scoreDto = new ScoreCreateDto(
                $student->getKey(),
                $subject->getKey(),
                new \DateTime($record['Дата сдачи экзамена']),
                (int) $record['Оценка'],
            );

            $this->scoreService->createOrUpdate($scoreDto);

            $this->logger->info(
                "Данные импортированы:
                Студент - {$studentDto->getName()},
                Предмет - {$subjectDto->getName()},
                Дата - {$record['Дата сдачи экзамена']},
                Оценка - {$record['Оценка']}"
            );
        }
    }
}
