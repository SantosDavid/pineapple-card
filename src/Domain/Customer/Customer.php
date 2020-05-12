<?php

namespace PineappleCard\Domain\Customer;

use DateTime;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Shared\ValueObject\Auth;
use PineappleCard\Domain\Shared\ValueObject\Money;

class Customer
{
    private CustomerId $id;

    private PayDay $payDay;

    private Money $limit;

    private DateTime $createdAt;

    private Auth $auth;

    public function __construct(CustomerId $id, PayDay $payDay, Money $limit, Auth $auth)
    {
        $this->id = $id;
        $this->payDay = $payDay;
        $this->limit = $limit;
        $this->createdAt = new DateTime();
        $this->auth = $auth;
    }

    public function id(): CustomerId
    {
        return $this->id;
    }

    public function auth(): Auth
    {
        return $this->auth;
    }

    public function payDay(): PayDay
    {
        return $this->payDay;
    }

    public function limit(): Money
    {
        return $this->limit;
    }
}
