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
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockHttpClient = $this->createMock(HttpClientInterface::class);
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

        $mockHttpClient->method('request')->willReturn($mockResponse);

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