<?php

namespace PineappleCard\Domain\Shared\ValueObject;

use InvalidArgumentException;

class Money
{
    private float $amount;

    private string $currency;

    public function __construct(float $amount, string $currency = 'BRL')
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function add(Money $money)
    {
        if ($money->currency !== $this->currency) {
            throw new InvalidArgumentException();
        }

        return new Money($this->amount + $money->amount);
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function sub(Money $money)
    {
        if ($money->currency !== $this->currency) {
            throw new InvalidArgumentException();
        }

        return new Money($this->amount - $money->amount());
    }
}
