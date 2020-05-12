<?php

namespace PineappleCard\Domain\Invoice\Exception;

use PineappleCard\Domain\Shared\Exception\BaseException;

class InvalidPeriodMonthException extends BaseException
{
    public function __construct(int $month)
    {
        parent::__construct("Month {$month} is not valid");
    }
}
