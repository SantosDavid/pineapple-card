<?php

namespace Tests\Application\Shared;

use PineappleCard\Domain\Customer\Customer;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Shared\ValueObject\Auth;
use PineappleCard\Domain\Shared\ValueObject\Money;

trait CreateCustomerHelper
{
    public function createCustomer(): Customer
    {
        return new Customer(
            new CustomerId(),
            new PayDay(10),
            new Money(1),
            new Auth('david@davi.com', '123456')
        );
    }
}
