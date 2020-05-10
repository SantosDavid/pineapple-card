<?php

namespace PineappleCard\Domain\Shared\Exception;

class CurrencyWrongCodeException extends BaseException
{
    public function __construct(string $code)
    {
        parent::__construct("The {$code} is not valid");
    }
}
