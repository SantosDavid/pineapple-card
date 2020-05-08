<?php

namespace PineappleCard\Domain\Shared\Exception;

use Exception;

class CurrencyWrongCodeException extends Exception
{
    public function __construct(string $code)
    {
        parent::__construct("The {$code} is not valid");
    }
}
