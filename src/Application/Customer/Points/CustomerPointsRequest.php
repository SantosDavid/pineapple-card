<?php

namespace PineappleCard\Application\Customer\Points;

class CustomerPointsRequest
{
    private string $customerId;

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): CustomerPointsRequest
    {
        $this->customerId = $customerId;

        return $this;
    }
}
