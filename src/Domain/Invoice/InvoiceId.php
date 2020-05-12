<?php

namespace PineappleCard\Domain\Invoice;

use Ramsey\Uuid\Uuid;

class InvoiceId
{
    private string $id;

    public function __construct(string $id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function equals(InvoiceId $invoiceId): bool
    {
        return $this->id === $invoiceId->id();
    }

    public function __toString()
    {
        return $this->id;
    }
}
