<?php

namespace PineappleCard\Domain\Invoice;

use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Invoice\ValueObject\Period;
use PineappleCard\Domain\Invoice\ValueObject\Status;

class Invoice
{
    private InvoiceId $invoiceId;

    private CustomerId $customerId;

    private Period $period;

    private Status $status;

    public function __construct(InvoiceId $invoiceId, CustomerId $customerId, Period $period, Status $status)
    {
        $this->invoiceId = $invoiceId;
        $this->customerId = $customerId;
        $this->period = $period;
        $this->status = $status;
    }

    public function id(): InvoiceId
    {
        return $this->invoiceId;
    }
}
