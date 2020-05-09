<?php

namespace PineappleCard\Domain\Customer;

use DateTime;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Shared\ValueObject\Money;

class Customer
{
    private CustomerId $id;

    private PayDay $payDay;

    private Money $limit;

    private DateTime $createdAt;

    public function __construct(CustomerId $id, PayDay $payDay, Money $limit)
    {
        $this->id = $id;
        $this->payDay = $payDay;
        $this->limit = $limit;
        $this->createdAt = new DateTime();
    }
}
