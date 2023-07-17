<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Subject;
use App\Repositories\SubjectRepository;
use App\Services\DTO\SubjectCreateDto;

class SubjectService
{
    private SubjectRepository $subjectRepository;

    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Создает новый предмет или возвращает существующий.
     *
     * @param SubjectCreateDto $dto объект DTO, содержащий информацию о предмете
     *
     * @return Subject возвращает созданный или существующий предмет
     */
    public function createOrGet(SubjectCreateDto $dto): Subject
    {
        $subject = $this->subjectRepository->getByName($dto->getName());

        if ($subject) {
            return $subject;
        }

        $newSubject = new Subject();
        $newSubject->name = $dto->getName();
        $this->subjectRepository->save($newSubject);

        return $newSubject;
    }
}
