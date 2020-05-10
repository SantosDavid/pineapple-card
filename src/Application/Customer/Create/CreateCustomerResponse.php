<?php

namespace PineappleCard\Application\Customer\Create;

use PineappleCard\Domain\Customer\CustomerId;

class CreateCustomerResponse
{
    private CustomerId $customerId;

    public function __construct(CustomerId $customerId)
    {
        $this->customerId = $customerId;
    }

    public function __toString()
    {
        return json_encode(['id' => $this->customerId->id()]);
    }
}
