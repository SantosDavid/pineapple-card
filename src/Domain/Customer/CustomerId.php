<?php

namespace PineappleCard\Domain\Customer;

use PineappleCard\Domain\Shared\Uuid;

class CustomerId extends Uuid
{
    public function equals(CustomerId $customerId): bool
    {
        return $this->id === $customerId->id();
    }
}
