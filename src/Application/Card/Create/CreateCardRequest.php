<?php

namespace PineappleCard\Application\Card\Create;

class CreateCardRequest
{
    private string $customerId;

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): CreateCardRequest
    {
        $this->customerId = $customerId;

        return $this;
    }
}
