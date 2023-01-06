<?php

namespace App\Tests\Unit\Service;

use App\Enum\HealthStatus;
use App\Service\GitHubService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GitHubServiceTest extends TestCase
{
    /**
     * @dataProvider dinoNameProvider
     */
    public function testGetHealthReportReturnsCorrectHealthStatusForDino(HealthStatus $expectedStatus, string $dinoName): void
    {
        /** @var LoggerInterface&\PHPUnit\Framework\MockObject\MockObject */
        $mockLogger = $this->createMock(LoggerInterface::class);
        /** @var HttpClientInterface&\PHPUnit\Framework\MockObject\MockObject */
        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        /** @var ResponseInterface&\PHPUnit\Framework\MockObject\MockObject */
        $mockResponse = $this->createMock(ResponseInterface::class);

        $mockResponse->method('toArray')->willReturn([
            [
                'title' => 'Daisy',
                'labels' => [['name' => 'Status: Sick']]
            ],
            [
                'title' => 'Maverick',
                'labels' => [['name' => 'Status: Healthy']]
            ]
        ]);

        $mockHttpClient
            ->expects(self::once())
            ->method('request')
            ->with('GET', 'https://api.github.com/repos/SymfonyCasts/dino-park/issues')
            ->willReturn($mockResponse);

        $service = new GitHubService($mockHttpClient, $mockLogger);

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