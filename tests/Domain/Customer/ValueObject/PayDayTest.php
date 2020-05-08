<?php

namespace Tests\Domain\Customer\ValueObject;

use App\Domain\Customer\Exception\PayDayIsNotValidException;
use App\Domain\Customer\ValueObject\PayDay;
use PHPUnit\Framework\TestCase;

class PayDayTest extends TestCase
{
    public function invalidDaysProvider()
    {
        return [
            [1],
            [6],
            [8],
            [29]
        ];
    }

    /**
     * @dataProvider invalidDaysProvider
     */
    public function testShouldRaiseExceptionWhenDayIsOutRange($day)
    {
        $this->expectException(PayDayIsNotValidException::class);


        new PayDay($day);
    }


    public function validDaysProvider()
    {
        return [
            [5],
            [10],
            [15]
        ];
    }

    /**
     * @dataProvider validDaysProvider
     */
    public function testShouldCreateValueObject($day)
    {
        $payDay = new PayDay($day);


        $this->assertEquals($day, $payDay->day());
    }
}
