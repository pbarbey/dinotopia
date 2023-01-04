<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Dinosaur;
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
}