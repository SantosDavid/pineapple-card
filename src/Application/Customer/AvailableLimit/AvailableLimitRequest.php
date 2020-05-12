<?php

namespace PineappleCard\Application\Customer\AvailableLimit;

class AvailableLimitRequest
{
    private string $customerId;

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): AvailableLimitRequest
    {
        $this->customerId = $customerId;

        return $this;
    }
}
