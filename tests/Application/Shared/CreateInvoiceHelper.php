<?php

namespace Tests\Application\Shared;

use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceId;

trait CreateInvoiceHelper
{
    public function createInvoice($paid = false, CustomerId $customerId = null): Invoice
    {
        return new Invoice(
            new InvoiceId(),
            $customerId ?? new CustomerId(),
            new PayDay(10),
            new \DateTime(),
            $paid
        );
    }
}
