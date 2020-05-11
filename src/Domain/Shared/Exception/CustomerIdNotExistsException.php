<?php

namespace PineappleCard\Domain\Shared\Exception;

use PineappleCard\Domain\Customer\CustomerId;

class CustomerIdNotExistsException extends BaseException
{
    public function __construct(CustomerId $customerId)
    {
        parent::__construct("Customer id {$customerId->id()} do not exists");
    }
}
