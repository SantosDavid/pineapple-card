<?php

namespace PineappleCard\Domain\Invoice;

use PineappleCard\Domain\Customer\CustomerId;
use Tightenco\Collect\Support\Collection;

interface InvoiceRepository
{
    public function create(Invoice $invoice): Invoice;

    public function byCustomer(CustomerId $customerId): Collection;
}
