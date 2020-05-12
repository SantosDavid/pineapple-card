<?php

namespace PineappleCard\Domain\Invoice;

use PineappleCard\Domain\Shared\Uuid;

class InvoiceId extends Uuid
{
    public function equals(InvoiceId $invoiceId): bool
    {
        return $this->id === $invoiceId->id();
    }
}
