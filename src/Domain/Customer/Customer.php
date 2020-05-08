<?php

namespace App\Domain\Customer;

use App\Domain\Customer\ValueObject\CustomerId;
use App\Domain\Customer\ValueObject\PayDay;
use App\Domain\Shared\ValueObject\Money;

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
