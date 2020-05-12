<?php

namespace Tests\Domain\Invoice\ValueObject;

use PHPUnit\Framework\TestCase;
use PineappleCard\Domain\Invoice\Exception\InvalidPeriodMonthException;
use PineappleCard\Domain\Invoice\ValueObject\Period;

class PeriodTest extends TestCase
{
    public function invalidMonthsProvider()
    {
        return [
            [0],
            [-1],
            [15],
            [21],
            [28]
        ];
    }

    /**
     * @dataProvider invalidMonthsProvider
     */
    public function testShouldRaiseExceptionWhenMonthIsInvalid(int $month)
    {
        $this->expectException(InvalidPeriodMonthException::class);


        new Period($month, 200);
    }
}
