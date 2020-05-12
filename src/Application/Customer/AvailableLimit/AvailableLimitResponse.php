<?php

namespace PineappleCard\Application\Customer\AvailableLimit;

class AvailableLimitResponse
{
    private float $amount;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public function amount()
    {
        return $this->amount;
    }
}
