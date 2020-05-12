<?php

namespace PineappleCard\Domain\Invoice;

use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Invoice\ValueObject\Period;

interface InvoiceRepository
{
    public function create(Invoice $invoice): Invoice;

    public function byPeriod(CustomerId $customerId, Period $period): ?Invoice;
}
