<?php

namespace PineappleCard\Application\Invoice\Overview;

use DateTime;

class OverviewInvoiceResponse
{
    private array $invoices = [];

    private float $availableLimit;

    public function addInvoice(string $invoiceId, string $status, DateTime $dueDate, array $transactions): OverviewInvoiceResponse
    {
        $this->invoices[] = [
            'id' => $invoiceId,
            'status' => $status,
            'dueDate' => $dueDate->format('d/m'),
            'transactions' => $transactions,
        ];

        return $this;
    }

    public function setAvailableLimit(float $availableLimit): OverviewInvoiceResponse
    {
        $this->availableLimit = $availableLimit;

        return $this;
    }

    public function getAvailableLimit(): float
    {
        return $this->availableLimit;
    }

    public function getInvoices(): array
    {
        return $this->invoices;
    }

    public function __toString()
    {
        return json_encode([
            'available_limit' => $this->availableLimit,
            'invoices' => $this->invoices,
        ]);
    }
}
