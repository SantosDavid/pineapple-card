<?php

namespace PineappleCard\Domain\Shared\ValueObject;

class Money
{
    private float $amount;

    private Currency $currency;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
        $this->currency = new Currency();
    }
}
