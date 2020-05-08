<?php

namespace PineappleCard\Domain\Customer;

use PineappleCard\Domain\Customer\ValueObject\CustomerId;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Shared\ValueObject\Money;

class Customer
{
    private CustomerId $id;

    private PayDay $payDay;

    private Money $limit;

    public function __construct(CustomerId $id, PayDay $payDay, Money $limit)
    {
        $this->id = $id;
        $this->payDay = $payDay;
        $this->limit = $limit;
    }
}
