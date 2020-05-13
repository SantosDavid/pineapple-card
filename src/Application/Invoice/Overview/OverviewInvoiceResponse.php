<?php

namespace PineappleCard\Application\Invoice\Overview;

use DateTime;

class OverviewInvoiceResponse
{
    private array $invoice;

    private float $availableLimit;

    public function addInvoice(string $status, DateTime $dueDate, array $transactions): OverviewInvoiceResponse
    {
        $this->invoice[] = [
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

    public function __toString()
    {
        return json_encode([
            'available_limit' => $this->availableLimit,
            'invoices' => $this->invoice,
        ]);
    }
}
