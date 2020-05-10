<?php

namespace PineappleCard\Domain\Customer\Exception;

use PineappleCard\Domain\Shared\Exception\BaseException;

class PayDayIsNotValidException extends BaseException
{
    public function __construct(int $payDay, array $acceptedDays)
    {
        $days = implode(',', $acceptedDays);

        parent::__construct("Payday to day {$payDay} is not accepted. The range is: {$days}");
    }
}
