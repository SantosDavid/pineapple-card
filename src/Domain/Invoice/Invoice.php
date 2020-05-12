<?php

namespace PineappleCard\Domain\Invoice;

use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Invoice\ValueObject\Period;
use PineappleCard\Domain\Invoice\ValueObject\Status;

class Invoice
{
    private InvoiceId $invoiceId;

    private CardId $cardId;

    private Period $period;

    private Status $status;

    public function __construct(InvoiceId $invoiceId, CardId $cardId, Period $period, Status $status)
    {
        $this->invoiceId = $invoiceId;
        $this->period = $period;
        $this->status = $status;
        $this->cardId = $cardId;
    }

    public function id(): InvoiceId
    {
        return $this->invoiceId;
    }
}
