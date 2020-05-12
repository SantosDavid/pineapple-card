<?php

namespace PineappleCard\Domain\Invoice\Exception;

use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Shared\Exception\BaseException;

class InvoiceOpenedCannotBePaidException extends BaseException
{
    public function __construct(InvoiceId $invoiceId)
    {
        parent::__construct("Invoice {$invoiceId->id()} cannot be paid, because is still opened");
    }
}
