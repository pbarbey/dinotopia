<?php

namespace App\Tests\Unit\Service;

use App\Enum\HealthStatus;
use App\Service\GitHubService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class GitHubServiceTest extends TestCase
{
    /**
     * @dataProvider dinoNameProvider
     */
    public function testGetHealthReportReturnsCorrectHealthStatusForDino(HealthStatus $expectedStatus, string $dinoName): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);

        $service = new GitHubService($mockLogger);

        self::assertSame($expectedStatus, $service->getHealthReport($dinoName));
    }

    public function dinoNameProvider()
    {
        yield 'Sick dino' => [
            HealthStatus::SICK,
            'Daisy'
        ];

        yield 'Heathy dino' => [
            HealthStatus::HEALTHY,
            'Maverick'  
        ];
    }
}