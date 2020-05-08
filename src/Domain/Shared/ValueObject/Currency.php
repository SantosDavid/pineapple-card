<?php

namespace PineappleCard\Domain\Shared\ValueObject;

use PineappleCard\Domain\Shared\Exception\CurrencyWrongCodeException;

class Currency
{
    private string $code;

    public function __construct($code = 'BRL')
    {
        if (!preg_match('/^[A-Z]{3}$/', $code)) {
            throw new CurrencyWrongCodeException($code);
        }

        $this->code = $code;
    }
}
