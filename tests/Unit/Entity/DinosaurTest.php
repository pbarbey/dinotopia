<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Dinosaur;
use App\Enum\HealthStatus;
use PHPUnit\Framework\TestCase;

class DinosaurTest extends TestCase
{
    public function testCanGetAndSaveData(): void
    {
        $dino = new Dinosaur(
            name: 'Big eaty',
            genus: 'Tyranosaurus',
            length: 15,
            enclosure: 'Padding A'
        );

        self::assertSame('Big eaty', $dino->getName());
        self::assertSame('Tyranosaurus', $dino->getGenus());
        self::assertSame(15, $dino->getLength());        
        self::assertSame('Padding A', $dino->getEnclosure());        
    }

    // public function testDinosaurOver10MetersOrGreaterIsLarge(): void
    // {
    //     $dino = new Dinosaur(name: 'Big eaty', length: 10);

    //     self::assertSame('Large', $dino->getSizeDescription(), 'This is supposed to be a big dino');
    // }

    // public function testDinosaurBetween5And9MetersIsMedium(): void
    // {
    //     $dino = new Dinosaur(name: 'Big eaty', length: 5);

    //     self::assertSame('Medium', $dino->getSizeDescription(), 'This is supposed to be a medium dino');
    // }

    // public function testDinosaurUnder5MeterIsSmall(): void
    // {
    //     $dino = new Dinosaur(name: 'Big eaty', length: 4);

    //     self::assertSame('Small', $dino->getSizeDescription(), 'This is supposed to be a medium dino');
    // }

    /**
     * @dataProvider sizeDescriptionProvider
     */
    public function testDinoHasCorrectSizeFromLength(int $length, string $expectedSize):void
    {
    $dino = new Dinosaur(name: 'Big eaty', length: $length);

    self::assertSame($expectedSize, $dino->getSizeDescription());
    }

    public function sizeDescriptionProvider(): \Generator
    {
        yield '10 meter large dino' => [10, 'Large'];
        yield '5 meter medium dino' => [5, 'Medium'];
        yield '4 meter small dino' => [4, 'Small'];
    }

    public function testIsAcceptiongVisitorByDefault(): void
    {
        $dino = new Dinosaur('Dennis');

        self::assertTrue($dino->isAcceptingVisitors());
    }

    public function testIsNotAcceptingVisiotorsIfSick(): void
    {
        $dino = new Dinosaur('Bumpy');
        $dino->setHealth(HealthStatus::SICK);

        self::assertFalse($dino->isAcceptingVisitors());
    }

}