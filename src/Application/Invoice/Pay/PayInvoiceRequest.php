<?php

namespace PineappleCard\Application\Invoice\Pay;

class PayInvoiceRequest
{
    private string $customerId;

    private string $invoiceId;

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): PayInvoiceRequest
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function getInvoiceId(): string
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(string $invoiceId): PayInvoiceRequest
    {
        $this->invoiceId = $invoiceId;
        return $this;
    }
}
