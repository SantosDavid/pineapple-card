<?php

namespace PineappleCard\Domain\Customer\Exception;

use Exception;

class PayDayIsNotValidException extends Exception
{
    public function __construct(int $payDay, array $acceptedDays)
    {
        $days = implode(',', $acceptedDays);

        parent::__construct("Payday to day {$payDay} is not accepted. The range is: {$days}");
    }
}
