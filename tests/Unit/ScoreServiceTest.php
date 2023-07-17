<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Repositories\ScoreRepository;
use App\Services\ScoreService;
use Illuminate\Cache\Repository as CacheRepository;
use PHPUnit\Framework\TestCase;

class ScoreServiceTest extends TestCase
{
    private ScoreRepository $scoreRepositoryMock;
    private CacheRepository $cacheRepositoryMock;

    private string $subjectName;
    private array $scores;
    private float $expectedAverageScores;

    protected function setUp(): void
    {
        parent::setUp();

        $this->scoreRepositoryMock = $this->createMock(ScoreRepository::class);
        $this->cacheRepositoryMock = $this->createMock(CacheRepository::class);

        $this->subjectName = 'Science';
        $this->scores = [80, 75, 85];
        $this->expectedAverageScores = 80;
    }

    public function testCalculateAverageScoreBySubjectCacheHit(): void
    {
        $this->scoreRepositoryMock->expects($this->once())
            ->method('getOnlyScoresBySubject')
            ->with($this->subjectName)
            ->willReturn($this->scores);

        $this->cacheRepositoryMock->expects($this->exactly(2))
            ->method('tags')
            ->with([$this->subjectName])
            ->willReturnSelf();

        $this->cacheRepositoryMock->expects($this->once())
            ->method('has')
            ->with($this->subjectName)
            ->willReturn(true);

        $this->cacheRepositoryMock->expects($this->once())
            ->method('get')
            ->with("avg_scores_{$this->subjectName}")
            ->willReturn($this->expectedAverageScores);

        $scoreService = new ScoreService($this->scoreRepositoryMock, $this->cacheRepositoryMock);

        $averageScore = $scoreService->calculateAverageScoreBySubject($this->subjectName);

        $this->assertEquals($this->expectedAverageScores, $averageScore);
    }

    public function testCalculateAverageScoreBySubjectCacheMiss(): void
    {
        $this->scoreRepositoryMock->expects($this->once())
            ->method('getOnlyScoresBySubject')
            ->with($this->subjectName)
            ->willReturn($this->scores);

        $this->cacheRepositoryMock->expects($this->exactly(2))
            ->method('tags')
            ->with([$this->subjectName])
            ->willReturnSelf();

        $this->cacheRepositoryMock->expects($this->once())
            ->method('has')
            ->with($this->subjectName)
            ->willReturn(false);

        $this->cacheRepositoryMock->expects($this->once())
            ->method('put')
            ->with("avg_scores_{$this->subjectName}", $this->expectedAverageScores);

        $scoreService = new ScoreService($this->scoreRepositoryMock, $this->cacheRepositoryMock);

        $averageScore = $scoreService->calculateAverageScoreBySubject($this->subjectName);

        $this->assertEquals($this->expectedAverageScores, $averageScore);
    }

    public function testCalculateAverageScoreBySubjectReturnNull(): void
    {
        $this->scoreRepositoryMock->expects($this->once())
            ->method('getOnlyScoresBySubject')
            ->with($this->subjectName)
            ->willReturn([]);

        $scoreService = new ScoreService($this->scoreRepositoryMock, $this->cacheRepositoryMock);

        $averageScore = $scoreService->calculateAverageScoreBySubject($this->subjectName);

        $this->assertNull($averageScore);
    }
}
