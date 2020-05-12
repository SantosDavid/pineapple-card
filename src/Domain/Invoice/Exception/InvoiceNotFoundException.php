<?php

namespace PineappleCard\Domain\Invoice\Exception;

use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Shared\Exception\BaseException;

class InvoiceNotFoundException extends BaseException
{
    public function __construct(InvoiceId $invoiceId)
    {
        parent::__construct("InvoiceId {$invoiceId->id()} not founded");
    }
}
