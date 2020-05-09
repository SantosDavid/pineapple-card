<?php

namespace PineappleCard\Domain\Shared\ValueObject;

class Money
{
    private float $amount;

    private string $currency;

    public function __construct(float $amount, string $currency = 'BRL')
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }
}
