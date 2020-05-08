<?php

namespace App\Domain\Customer\Exception;

use Exception;
use Throwable;

class PayDayIsNotValidException extends Exception
{
    public function __construct(int $payDay, array $acceptedDays)
    {
        $days = implode(',', $acceptedDays);

        parent::__construct("Payday to day {$payDay} is not accepted. The range is: {$days}");
    }
}
