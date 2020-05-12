<?php

namespace PineappleCard\Application\Invoice\FindOrCreate;

class FindOrCreateInvoiceRequest
{
    private string $customerId;

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): FindOrCreateInvoiceRequest
    {
        $this->customerId = $customerId;
        return $this;
    }
}
