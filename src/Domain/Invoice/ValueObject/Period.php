<?php

namespace PineappleCard\Domain\Invoice\ValueObject;

use PineappleCard\Domain\Invoice\Exception\InvalidPeriodMonthException;

class Period
{
    private int $month;
    private int $year;

    public function __construct(int $month, int $year)
    {
        $this->setMonth($month);
        $this->year = $year;
    }

    private function setMonth(int $month)
    {
        if ($month < 1 || $month > 12) {
            throw new InvalidPeriodMonthException($month);
        }

        $this->month = $month;
    }
}
