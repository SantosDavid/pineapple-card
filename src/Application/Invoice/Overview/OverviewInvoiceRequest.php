<?php

namespace PineappleCard\Application\Invoice\Overview;

class OverviewInvoiceRequest
{
    private string $customerId;

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): OverviewInvoiceRequest
    {
        $this->customerId = $customerId;
        return $this;
    }
}
