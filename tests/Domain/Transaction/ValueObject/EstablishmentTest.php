<?php

namespace Tests\Domain\Transaction\ValueObject;

use PHPUnit\Framework\TestCase;
use PineappleCard\Domain\Shared\ValueObject\Geolocation;
use PineappleCard\Domain\Transaction\Exception\InvalidEstablishmentCategoryException;
use PineappleCard\Domain\Transaction\ValueObject\Establishment;

class EstablishmentTest extends TestCase
{
    public function testShouldRaiseExceptionWhenCategoryIsNotValid()
    {
        $this->expectException(InvalidEstablishmentCategoryException::class);


        new Establishment('Establishment',10, new Geolocation(1, 2));
    }

    public function testShouldSetRightScore()
    {
        $establishment = new Establishment('Establishment',1, new Geolocation(1, 1));

        $this->assertEquals(0.8, $establishment->scoreRate());
    }
}
