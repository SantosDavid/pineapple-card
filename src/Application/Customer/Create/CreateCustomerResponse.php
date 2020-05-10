<?php

namespace PineappleCard\Application\Customer\Create;

use JsonSerializable;
use PineappleCard\Domain\Customer\CustomerId;

class CreateCustomerResponse implements JsonSerializable
{
    private CustomerId $customerId;

    public function __construct(CustomerId $customerId)
    {
        $this->customerId = $customerId;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->customerId->id()
        ];
    }
}
