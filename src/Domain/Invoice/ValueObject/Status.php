<?php

namespace PineappleCard\Domain\Invoice\ValueObject;

class Status
{
    private string $status;

    public function __construct()
    {
        $this->status = 'opened';
    }
}
