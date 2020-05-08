<?php

namespace PineappleCard\Domain\Customer\ValueObject;

use PineappleCard\Domain\Customer\Exception\PayDayIsNotValidException;

class PayDay
{
    private array $daysAccepted = [5, 10, 15];

    private int $day;

    public function __construct(int $day)
    {
        if (!in_array($day, $this->daysAccepted)) {
            throw new PayDayIsNotValidException($day, $this->daysAccepted);
        }
        
        $this->day = $day;
    }

    public function day()
    {
        return $this->day;
    }
}
