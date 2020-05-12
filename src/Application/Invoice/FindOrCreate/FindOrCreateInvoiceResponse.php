<?php

namespace PineappleCard\Application\Invoice\FindOrCreate;

use PineappleCard\Domain\Invoice\InvoiceId;

class FindOrCreateInvoiceResponse
{
    private InvoiceId $invoiceId;

    public function __construct(InvoiceId $invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    public function id(): InvoiceId
    {
        return $this->invoiceId;
    }
}
